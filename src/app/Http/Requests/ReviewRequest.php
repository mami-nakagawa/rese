<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'star' => 'required',
            'comment' => 'required|min:10',
        ];
    }

    public function messages()
    {
        return [
            'star.required' => '評価を選択してください',
            'comment.required' => 'コメントを入力してください',
            'comment.min' => 'コメントは10文字以上で入力してください',
        ];
    }
}
