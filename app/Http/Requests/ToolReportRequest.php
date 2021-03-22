<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToolReportRequest extends FormRequest
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
            'rep-borrower' => [
                'required',
            ],
            'repreason' => [
                'required',
            ],
            'repnum' => [
                '',
            ],
            'reptoolId' => [
                '',
            ],
            'repBarcode' => [
                '',
            ],
        ];
    }

    public function messages()
    {
        return [
            'rep-borrower' => 'Borrower is required.<br>',
            'repreason' => 'Reason is required.<br>',
        ];
    }
}
