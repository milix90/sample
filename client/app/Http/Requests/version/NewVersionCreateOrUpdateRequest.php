<?php

namespace App\Http\Requests\version;

use Anik\Form\FormRequest;

class NewVersionCreateOrUpdateRequest extends FormRequest
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
            'version' => ['required', 'numeric', 'max:16'],
            'app_file' => ['nullable', 'file', 'mimes:zip', 'size:200000'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'size:5000'],
            'change_log' => ['nullable', 'string'],
        ];
    }
}
