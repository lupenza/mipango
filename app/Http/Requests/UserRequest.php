<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'phone_number'  =>['required','min:12','max:12'],
            'first_name'    =>['required','max:50','min:3'],
            'middle_name'   =>['required','max:50','min:3'],
            'last_name'     =>['required','max:50','min:3'],
            'username'      =>['required','unique:users,username'],
            'user_role'     =>'required'
        ];
    }
}
