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

    public function messages()
    {
        return [
            'studnum.required' => 'Student number is required.<br>', 
            'studnum.unique' => 'Student number has already been taken.<br>', 
            'firstname.required' => 'First Name is required.<br>', 
            'lastname.required' => 'Last Name is required.<br>', 
            'contact.required' => 'Contact number is required.<br>', 
            'contact.unique' => 'Contact number has already been taken.<br>', 
            'sex.required' => 'Sex is required.<br>', 
            'year.required' => 'Year is required.<br>', 
            'year.integer' => 'Year must be a number.<br>', 
            'year.gte' => 'Year must be greater than 1.<br>', 
            'year.lte' => 'Year must be less than 5.<br>', 
            'section.required' => 'Section is required.<br>', 
            'college.required' => 'College is required.<br>', 
            'course.required' => 'Course is required.', 
        ];
    }
}
