<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankStoreRequest extends FormRequest
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
            'name'        =>['required','unique:banks,name'],
            'common_name' =>['required','unique:banks,common_name'],
            'account_type_id' =>'required',
            'image'        =>'required|image|mimes:jpg,png,jpeg,gif',
        ];
    }
}
