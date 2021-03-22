<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                'required',
                'unique:categories,description,'.$this->id,
            ]
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Category description is required.<br>',
            'description.unique' => 'Category description has already been taken.',
        ];
    }
}
