<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class csvValidationService extends ViewErrorBag
{
/**
 * 配列に格納されたCSVデータの行ごとに対してバリデーションチェックを行う
 * エラーがある場合はエラーメッセージ、ない場合はnullを返す
 */
public function validateCsvDate(array $csvData)
{
    // バリデーションルール
    $rules = [
        '0' => [
            'required',
            'string',
            'max:50',
        ],
        '1' => [
            'required',
            'string',
            'exists:areas,name',
        ],
        '2' => [
            'required',
            'string',
            'exists:genres,name',
        ],
        '3' => [
            'required',
            'string',
            'max:400',
        ],
        '4' => [
            'required',
            'url',
            'regex:/(jpeg|jpg|png)/',
        ],
    ];

    // バリデーション対象項目名
    $attributes = [
        '0' => '店舗名',
        '1' => '地域',
        '2' => 'ジャンル',
        '3' => '店舗概要',
        '4' => '画像URL',
    ];

    // 各行に対してバリデーションチェックを行い、エラーの場合はメッセージを格納する
    $upload_error_list = [];

    // すべての行に対してバリデーションチェックを行う
    $validator = Validator::make($csvData, $rules, __('validation'), $attributes);

    // バリデーションエラーがあった場合
    if($validator->fails()) {
        $errorMessage = array_map(fn($message) => "{$message}", $validator->errors()->all());
        $upload_error_list = array_merge($upload_error_list, $errorMessage);
    }


     // すべての行でバリデーションエラーがなかった場合
    if(empty($upload_error_list)) {
        return null;
    }

    // Requestのバリデーションエラーと同じ使い方をするため、エラーメッセージをViewErrorBagに入れる
    $errors = new ViewErrorBag();
    $messages = new MessageBag(['upload_errors' => $upload_error_list]);
    $errors->put('default', $messages);

    return $errors;
}
}