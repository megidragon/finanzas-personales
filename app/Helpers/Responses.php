<?php

namespace App\Helpers;

use \Illuminate\Http\JsonResponse;
/**
 * Trait para respuestas genericas.
 */
trait Responses {

    /**
     * Metodo de respuesta de almacenamiento correcto.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function storeSuccess($row=null) : JsonResponse {
        $response = [
            'code' => 200,
            'message' => 'Se creo el registro correctamente.'
        ];

        if (!empty($row)) {
            $response['data'] = $row;
        }
        return response()->json($response);
    }

    /**
     * Metodo de respuesta de almacenamiento correcto.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function deleteSuccess() : JsonResponse {
        return response()->json([
            'code' => 200,
            'message' => 'Se elimino el registro correctamente.'
        ]);
    }

    /**
     * Metodo de respuesta de almacenamiento correcto.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function updateSuccess($row=null) : JsonResponse{
        $response = [
            'code' => 200,
            'message' => 'Se actualizo el registro correctamente.'
        ];

        if (!empty($row)) {
            $response['data'] = $row;
        }
        return response()->json($response);
    }

    /**
     * Metodo de respuesta de fallo de validacion.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validateFailed($messages=null) : JsonResponse {
        return response()->json([
            'code' => 422,
            'message' => $messages ?: 'Fallo la validacion de los datos'
        ]);
    }

    /**
     * Metodo de respuesta de listado.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function listResponse($rows) : JsonResponse {
        $response = [
            'code' => 200,
            'message' => null,
            'data' => $rows
        ];

        return response()->json($response);
    }
}