<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true; // 誰でも送信可能
    }

    public function rules(): array
    {
        return [
            'last_name'     => 'required|string',
            'first_name'    => 'required|string',
            'gender'        => 'required|in:男性,女性,その他',
            'email'         => 'required|email',
            'tel1' => ['nullable'], // 個別には必須にしない
            'tel2' => ['nullable'],
            'tel3' => ['nullable'],
            'address'       => 'required|string',
            'category_id'   => 'required|exists:categories,id',
            'content'       => 'required|string|max:120',
        ];
    }

    public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $tel1 = $this->tel1;
        $tel2 = $this->tel2;
        $tel3 = $this->tel3;

        // どれか1つでも欠けている場合
        if (!$tel1 || !$tel2 || !$tel3) {
            $validator->errors()->add('tel', '電話番号を入力してください');
            return;
        }

        // 各欄ごとのチェック
        foreach (['tel1', 'tel2', 'tel3'] as $telField) {
            $value = $this->$telField;

            if ($value) {
                if (!preg_match('/^[0-9]+$/', $value)) {
                    $validator->errors()->add('tel', '電話番号は半角数字で入力してください');
                }

                if (strlen($value) > 5) {
                    $validator->errors()->add('tel', '電話番号は5桁までの数字で入力してください');
                }
            }
        }
    });
}

    public function messages()
    {
        return [
            'last_name.required'    => '姓を入力してください',
            'first_name.required'   => '名を入力してください',
            'gender.required'       => '性別を選択してください',
            'gender.in'             => '性別を選択してください',
            'email.required'        => 'メールアドレスを入力してください',
            'email.email'           => 'メールアドレスはメール形式で入力してください',
            'address.required'      => '住所を入力してください',
            'category_id.required'  => 'お問い合わせの種類を選択してください',
            'content.required'      => 'お問い合わせ内容を入力してください',
            'content.max'           => 'お問合せ内容は120文字以内で入力してください',
        ];
    }
}