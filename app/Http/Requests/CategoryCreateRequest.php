<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
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
            'name' => 'required|string|max:254',
            'client_id' => 'required|integer|max:10',
            'type' => 'required|in:deposit,spending',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute es obligatorio.',
            'name.max' => ':attribute debe ser menor a 254 caracteres.',
            'client_id.required' => ':attribute es obligatorio.',
            'client_id.max' => ':attribute debe ser menor a 10 digitos.',
            'type.required' => ':attribute es obligatorio.',
            'type.in' => ':attribute debe ser "deposit" o "spending".',
        ];
    }
}
