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
            'description' => ['required', 'unique:courses,description'],
            'code' => ['required', 'unique:courses,code']
        ];
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'description.required' => 'Course description is required. <br>',
            'description.unique' => 'Course description is already in the database. <br>',
            'code.required' => 'Course code is required. <br>',
            'code.unique' => 'Course code is already in the database. <br>',
        ];
    }
}
