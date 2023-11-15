<?php

namespace App\Http\Requests\SuperAdmin\Menu;

use Illuminate\Foundation\Http\FormRequest;

class NavRequest extends FormRequest
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
            'parent_id'=>'required',
            'type'=>'required',
            'title'=>'required_if:type,none|required_if:type,link',
            'url'=>'required_if:type,link',
            'type_id'=>'required_if:type,page',
            'image'=>'sometimes||mimes:jpeg,jpg,png,gif',
            'status'=>'required',
        ];
    }
}
