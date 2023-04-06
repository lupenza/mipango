<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Management\AccountType;


class AccountTypeUpdateRequest extends FormRequest
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
        $account =AccountType::where('uuid',$this->input('uuid'))->first();
        return [
            'name'    =>['required','unique:account_type,name,'.$account->id],
            'name_sw' =>['required','unique:account_type,name_sw,'.$account->id],
            'description' =>'required',
            'uuid'        =>'required',
        ];
    }
}
