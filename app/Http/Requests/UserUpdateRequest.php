<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'phone_number'  =>['required','min:10','max:10'],
            'name'          =>['required','max:70','min:3'],
            'last_name'          =>['required','max:70','min:3'],
            'user_uuid'          =>'required'
        ];
    }
}
