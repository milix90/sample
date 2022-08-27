<?php

namespace App\Http\Requests\application;

use Anik\Form\FormRequest;

class ApplicationCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:applications,name'],
            'description' => ['required', 'string', 'max:1000'],
        ];
    }
}
