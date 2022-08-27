<?php

namespace App\Http\Requests\auth;

use Anik\Form\FormRequest;
use App\Rules\UsernameRule;

class ResetPasswordRequest extends FormRequest
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
     * @return array[]
     */
    protected function rules(): array
    {
        return [
            'username' => ['required', new UsernameRule],
        ];
    }
}
