<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRegisterRequest extends FormRequest
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
            'name' => 'required',
            'area_id' => 'required',
            'genre_id' => 'required',
            'summary' => 'required',
            'image' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名を入力してください',
            'area_id.required' => '地域を選択してください',
            'genre_id.required' => 'ジャンルを選択してください',
            'summary.required' => '店舗概要を入力してください',
            'image.required' => '画像を選択してください',
        ];
    }
}
