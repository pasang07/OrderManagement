<?php

namespace App\Http\Requests\SuperAdmin\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'title'=>'required',
            'author'=>'required',
            'image'=>'sometimes|mimes:jpeg,jpg,png,gif',
            'content'=>'required',
//            'tags'=>'required',
        ];
    }
}
