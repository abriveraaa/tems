<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'college' => [
                'required',
            ],
            'description' => [
                'required', 
                'unique:courses,description,'.$this->id,
            ],
            'code' => [
                'required', 
                'unique:courses,code,'.$this->id,
            ],
        ];
    }

    public function messages()
    {
        return [
            'college.required' => 'College is required.<br>',
            'description.required' => 'Course name is required.<br>',
            'description.unique' => 'Course name has already been taken.<br>',
            'code.required' => 'Course code is required.<br>',
            'code.unique' => 'Course code has already been taken.',
        ];
    }
}
