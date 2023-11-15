<?php

namespace App\Http\Requests\SuperAdmin\Albums;

use Illuminate\Foundation\Http\FormRequest;

class AlbumsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'title'=>'required',
            'status'=>'required',
        ];
    }
}
