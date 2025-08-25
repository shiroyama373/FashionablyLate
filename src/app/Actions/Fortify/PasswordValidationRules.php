<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * パスワードのバリデーションルールを返す
     */
    protected function passwordRules()
    {
        return ['required', 'string', Password::min(8), 'confirmed'];
    }
}