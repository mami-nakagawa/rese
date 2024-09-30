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
            'comment' => 'required|max:400|string',
            'image' => 'file|mimes:jpeg,png|mimetypes:image/jpeg,image/png',
        ];
    }

    public function messages()
    {
        return [
            'star.required' => '評価を選択してください',
            'comment.required' => '口コミを入力してください',
            'comment.string' => '口コミは文字列で入力してください',
            'comment.max' => '口コミは400文字以内で入力してください',
            'image.file' => '画像は、ファイル形式でなければいけません',
            'image.mimetypes' => '画像には、jpegまたはpng形式を指定してください',
            'image.mines' => '画像には、jpegまたはpng形式を指定してください',
        ];
    }
}
