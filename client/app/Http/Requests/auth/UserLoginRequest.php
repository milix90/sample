<?php

namespace App\Http\Requests\auth;

use Anik\Form\FormRequest;
use App\Rules\UsernameRule;

class UserLoginRequest extends FormRequest
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
            'username' => ['required', new UsernameRule],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ];
    }
}
