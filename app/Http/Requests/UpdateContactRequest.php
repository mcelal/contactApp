<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],

            'last_name' => [
                'required',
                'string',
            ],

            'company' => [
                'string',
            ],

            'photo' => [
                'image',
                'max:2048',
                'mimes:jpg,jpeg,png,gif,svg'
            ]
        ];
    }
}
