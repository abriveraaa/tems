<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'description' => [
                'bail',
                'required',
                'unique:rooms,description,'.$this->id,
            ],
            'code' => [
                'bail',
                'required',
                'unique:rooms,code,'.$this->id,
            ]
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Room name is required.<br>',
            'description.unique' => 'Room name has already been taken.<br>',
            'code.required' => 'Room number is required.<br>',
            'code.unique' => 'Room number has already been taken.',
        ];
    }
}
