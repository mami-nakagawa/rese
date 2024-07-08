<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
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
            'date' => 'required',
            'time' => ['required',Rule::unique('reservations')->where('user_id', $this->input('user_id'))->where('shop_id', $this->input('shop_id'))->where('date', $this->input('date'))->where('time', $this->input('time'))],
            'number' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を選択してください',
            'time.required' => '予約時間を選択してください',
            'time.unique' => '既に同じ日時で予約されています',
            'number.required' => '予約人数を選択してください',
        ];
    }
}
