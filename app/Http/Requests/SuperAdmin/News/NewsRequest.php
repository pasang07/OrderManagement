<?php

namespace App\Http\Requests\SuperAdmin\News;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'image'=>'sometimes|mimes:jpeg,jpg,png,gif',
            'content'=>'required',
            'status'=>'required',
        ];
    }
}
