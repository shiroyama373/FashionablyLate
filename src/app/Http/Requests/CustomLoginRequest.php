<?php

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class CustomLoginRequest extends FortifyLoginRequest
{
    /**
     * バリデーションルールを上書き
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    /**
     * カスタムエラーメッセージを上書き
     */
    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
        ];
    }

    /**
     * バリデーション前に入力値を整形（必要に応じて）
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'email' => trim($this->email),
        ]);
    }
}