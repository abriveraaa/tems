<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BorrowerRequest extends FormRequest
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
            'borrower_image' => [
                'image',
                'max:2048',
            ],
            'studnum' => [
                'required',
                'unique:borrowers,studnum,'.$this->borrower_id,
            ],
            'firstname' => [
                'required',
            ],
            'midname' => [
                '',
            ],
            'lastname' => [
                'required',
            ],
            'contact' => [
                'required',
                'unique:borrowers,contact,'.$this->borrower_id,
            ], 
            'sex' => [
                'required',
            ], 
            'year' => [
                'required',
                'integer',
                'gte:1',
                'lte:5',
            ], 
            'section' => [
                'required',
            ], 
            'college' => [
                'required',
            ],
            'course' => [
                'required',
            ],
        ];
    }
}
