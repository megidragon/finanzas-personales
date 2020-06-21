<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
            'name' => 'string|max:254',
            'type' => 'in:deposit,spending',
        ];
    }

    public function messages()
    {
        return [
            'name.max' => ':attribute debe ser menor a 254 caracteres.',
            'type.in' => ':attribute debe ser "deposit" o "spending".',
        ];
    }
}
