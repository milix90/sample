<?php

namespace App\Http\Requests\auth;

use Anik\Form\FormRequest;
use App\Rules\UsernameRule;

class ActionsVerifyRequest extends FormRequest
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
            'action' => ['required', 'string',],// 'regex:/^[a-z0-9][=]*$/'//todo regex
        ];
    }
}
