<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UsernameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $email = filter_var($value, FILTER_VALIDATE_EMAIL);
        $mobile = preg_match("/^(\+98|0098|98|0)?9\d{9}$/i", $value);
        return ($email || $mobile);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('custom.error.validation.username');
    }
}
