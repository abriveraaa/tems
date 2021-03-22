<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToolRequest extends FormRequest
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
            'category' => [
                'required',
            ],
            'description' => [
                'required',
            ],
            'brand' => [
                '',
            ],
            'barcode' => [
                'required'
            ],
            'source' => [
                'required'
            ],
            'property' => [
                'unique:tools,property,'.$this->id,
            ],
            'admin_num' => [
                '',
            ],
        ];
    }

    public function messages()
    {
        return [
            'category.required' => 'Category is required.<br>',
            'description.required' => 'Tool description is required.<br>',
            'barcode.required' => 'Barcode is required.<br>',
            'source.required' => 'Source is required.<br>',
            'property.unique' => 'Property has already been taken.<br>',
        ];
    }
}
