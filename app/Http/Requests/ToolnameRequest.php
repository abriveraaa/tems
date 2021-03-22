<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToolnameRequest extends FormRequest
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
            'toolcategory' => [
                'required',
            ],
            'description' => [
                'required',
                'unique:tool_names,description,'.$this->toolname,
            ],
            'idtoolname' => [
                '',
            ]
        ];
    }

    public function messages()
    {
        return [
            'toolcategory.required' => 'Tool Category is required.<br>',
            'description.required' => 'Tool Name is required.<br>',
            'description.unique' => 'Tool Name has already been taken.<br>',
        ];
    }
}
