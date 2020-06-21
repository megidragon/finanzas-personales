<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
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
            'email' => 'string|min:7|max:254|unique:users',
            'full_name' => 'string|max:254',
            'birth_at' => 'date'
        ];
    }

    public function messages()
    {
        return [
            'email.max' => ':attribute debe ser menor a 254 caracteres.',
            'email.min' => ':attribute debe ser mayor a 7 caracteres.',
            'email.unique' => ':attribute ya fue tomado.',
            'full_name.required' => ':attribute es obligatorio.',
            'full_name.max' => ':attribute debe ser menor a 254 caracteres.',
            'birth_at.date' => ':attribute debe ser una fecha en formato YYYY-MM-DD',
        ];
    }
}
