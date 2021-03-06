<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovementCreateRequest extends FormRequest
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
        return !$this->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:1|max:254', 
            'description' => 'string|max:500', 
            'type' => 'required|in:'.\Config::get('constants.SPENDING_KEY').','.\Config::get('constants.DEPOSIT_KEY'),
            'amount' => 'required|numeric|min:0|max:999999.99', 
            'category_id' => 'required|integer|exists:categories,id',
            'currency_id' => 'required|integer|exists:currencies,id',
            'date_at' => 'date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attribute es obligatorio.',
            'title.max' => ':attribute debe ser menor a 254 caracteres.',
            'description.max' => ':attribute debe ser menor a 500 caracteres.',
            'type.required' => ':attribute es obligatorio.',
            'type.in' => ':attribute debe ser deposit o spending',
            'amount.required' => ':attribute es obligatorio.',
            'amount.min' => ':attribute debe ser mayor a 0.',
            'category_id.required' => ':attribute es obligatorio.',
            'category_id.integer' => ':attribute debe ser numerico.',
            'category_id.exists' => ':attribute debe ser un id existente valido.',
            'currency_id.required' => ':attribute es obligatorio.',
            'currency_id.integer' => ':attribute debe ser numerico.',
            'category_id.exists' => ':attribute debe ser un id existente valido.',
            'date_at.date' => ':attribute debe ser una fecha valida'
        ];
    }
}
