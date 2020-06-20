<?php

namespace App\Helpers;

/**
 * Trait para respuestas genericas.
 */
trait Responses {

    /**
     * Metodo de respuesta de almacenamiento correcto.
     */
    protected function storeSuccess($row=null) {
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
     */
    protected function deleteSuccess() {
        return response()->json([
            'code' => 200,
            'message' => 'Se elimino el registro correctamente.'
        ]);
    }

    /**
     * Metodo de respuesta de almacenamiento correcto.
     */
    protected function updateSuccess($row=null) {
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
     */
    protected function validateFailed($messages=null) {
        return response()->json([
            'code' => 422,
            'message' => $messages ?: 'Fallo la validacion de los datos'
        ]);
    }

    /**
     * Metodo de respuesta de listado.
     */
    protected function listResponse($rows) {
        $response = [
            'code' => 200,
            'message' => null,
            'data' => $rows
        ];

        return response()->json($response);
    }
}