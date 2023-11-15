<?php

namespace App\Http\Requests\SuperAdmin\Page;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'image'=>'sometimes||mimes:jpeg,jpg,png,gif|max:500000',
            'content'=>'required',
            'status'=>'required',
        ];
    }
}
