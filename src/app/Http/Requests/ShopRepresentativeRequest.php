<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopRepresentativeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required | string | max:100',
            'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($this->id), 'max:100'],
            'password' => 'required | string | min:8 | max:100'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗代表者名を入力してください',
            'name.string' => 'お名前を文字列で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.string' => 'メールアドレスを文字列で入力してください',
            'email.unique' => '入力されたメールアドレスは既に存在しています',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードを8文字以上で入力してください',
        ];
    }
}
