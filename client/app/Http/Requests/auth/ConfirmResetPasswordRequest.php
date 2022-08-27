<?php

namespace App\Http\Requests\auth;

use Anik\Form\FormRequest;

class ConfirmResetPasswordRequest extends FormRequest
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
     * @return array
     */
    protected function rules(): array
    {
        return [
            'reset_payload' => ['required', 'numeric', 'digits:16'],
            'password' => ['required', 'confirmed', 'string', 'min:8', 'max:255'],
        ];
    }
}
