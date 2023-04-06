<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Management\Category; 


class CategoryUpdaterequest extends FormRequest
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
        $category =Category::where('uuid',$this->input('uuid'))->first();
        return [
            'name'           =>['required','unique:categories,name,'.$category->id],
            'name_en'        =>['required','unique:categories,name_en,'.$category->id],
            'category_group' =>'required',
            'uuid'           =>'required',
        ];
    }
}
