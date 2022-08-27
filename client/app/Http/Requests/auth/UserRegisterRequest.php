<?php

namespace App\Http\Requests\auth;

use Anik\Form\FormRequest;
use App\Rules\ClientType;

class UserRegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'mobile' => ['required', 'regex:/^(\+98|0098|98|0)?9\d{9}$/i', 'digits:11', 'numeric', 'unique:users,mobile'],
            'phone' => ['nullable', 'regex:/^(\+98|0098|98|0)?1\d{9}$/i', 'digits:11', 'numeric', 'unique:users,phone'],
            'password' => ['required', 'confirmed', 'string', 'min:8', 'max:255'],
            'client_type' => ['required', new ClientType]
        ];
    }
}
