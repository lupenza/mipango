<?php

namespace App\Http\Requests;
use App\Models\Management\CategoryGroup;


use Illuminate\Foundation\Http\FormRequest;

class CategoryGroupUpdateRequest extends FormRequest
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
        $category =CategoryGroup::where('uuid',$this->input('uuid'))->first();
        return [
            'name'        =>['required','unique:category_groups,name,'.$category->id],
            'description' =>'required',
            'uuid'        =>'required',
        ];
    }
}
