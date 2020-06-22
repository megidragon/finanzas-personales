<?php

namespace App\Helpers;

trait ValidationHelper {
    protected function checkValidation($request)
    {
        if (isset($request->validator) && $request->validator->fails())
        {
            return false;
        } 
        return true;
    }
}