<?php

namespace App\Http\Requests\SuperAdmin\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'image'=>'sometimes|mimes:jpeg,jpg,png,gif|max:500000',
        ];
    }
}
