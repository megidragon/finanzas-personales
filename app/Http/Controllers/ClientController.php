<?php

namespace App\Http\Controllers;
use App\Http\Requests\ClientCreateRequest;
use App\Http\Requests\ClientUpdateRequest;

use Illuminate\Http\Request;
use App\Helpers\Responses;
use App\Helpers\ValidationHelper;
use App\User;
use App\Clients;

class ClientController extends Controller
{
    use Responses, ValidationHelper;

    /**
     * Detalles de clientes
     */
    protected function details($id) 
    {
        
        if (!auth()->user()->is_admin)
        {
            $client_id = User::clientId(auth()->id());
            if ($client_id != $id)
            {
                return response()->json(['message' => 'unauthorized.'], 401);
            }
        }

        $rows = Clients::with(['user', 'categories'])->find($id);
        
        return $this->listResponse($rows);
    }
    
    /**
     * Listado de clientes
     */
    protected function list() 
    {
        $rows = Clients::with('user')->get();
        
        return $this->listResponse($rows);
    }

    /**
     * Creacion de nuevo cliente
     */
    protected function store(ClientCreateRequest $request) 
    {
        // Validaciones correspondientes
        if (!$this->checkValidation($request))
        {
            return $this->validateFailed($request->validator->errors());
        }

        // Alta de usuario
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Alta de cliente
        $row = Clients::create([
            'full_name' => $request->full_name,
            'birth_at' => $request->birth_at,
            'profile_image' => null,
            'user_id' => $user->id,
        ])->fresh();
        
        return $this->storeSuccess($row);
    }

    /**
     * Actualizacion de cliente
     */
    protected function update(ClientUpdateRequest $request, $id) 
    {
        // Validaciones correspondientes
        if (!$this->checkValidation($request))
        {
            return $this->validateFailed($request->validator->errors());
        }
        
        $client = Clients::find($id);
        if (!$client || $client->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        if ($request->email)
        {
            $client->user()->update(['email' => $request->email]);
        }

        $input = $request->only(['full_name', 'birth_at']);

        $client->fill($input)->save();

        return $this->updateSuccess($client->fresh());
    }

    protected function upload(Request $request, $id)
    {
        $request->validate([
            'profile_image' => 'required|file|max:4096',
        ]);

        $client = Clients::find($id);
        if (!$client || $client->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $file_name = $this->saveImage($request, $client->user_id);
        $client->profile_image = url('/profiles/'.$file_name);
        $client->save();

        return response()->json([
            'code' => 200, 
            'message' => 'Se actualizo la imagen correctamente.',
            'data' => $client->fresh()
        ]);
    }

    /**
     * Borrado de cliente
     */
    protected function delete($id) 
    {
        $client = Clients::find($id);
        if (!$client || $client->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $client->delete();

        return $this->deleteSuccess();
    }

    /**
     * Realiza el guardado de imagne si se trajo.
     */
    private function saveImage($request, $user_id) 
    {
        $ext = $request->file('profile_image')->extension();
        $file_name = $user_id.'.'.$ext;
        $request->file('profile_image')->move(public_path('/profiles/'), $file_name);
        return $file_name;
    }
}
