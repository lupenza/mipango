<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class AccountTypeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'    =>['required','unique:account_type,name'],
            'name_sw' =>['required','unique:account_type,name_sw'],
            'description' =>'required'
        ];
    }
}
