<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
{
    public $validator = null;

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|min:7|max:254|unique:users',
            'password' => 'required|string|max:254',
            'password' => 'required|string|min:4|max:254',
            'full_name' => 'string|max:254',
            'birth_at' => 'date',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attribute es obligatorio.',
            'email.max' => ':attribute debe ser menor a 254 caracteres.',
            'email.min' => ':attribute debe ser mayor a 7 caracteres.',
            'email.unique' => ':attribute ya fue tomado.',
            'password.required' => ':attribute es obligatorio.',
            'password.max' => ':attribute debe ser menor a 254 caracteres.',
            'password.min' => ':attribute debe ser mayor a 4 caracteres.',
            'full_name.required' => ':attribute es obligatorio.',
            'full_name.max' => ':attribute debe ser menor a 254 caracteres.',
            'birth_at.date' => ':attribute debe ser una fecha en formato YYYY-MM-DD',
        ];
    }
}
