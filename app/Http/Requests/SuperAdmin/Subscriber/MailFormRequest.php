<?php

namespace App\Http\Requests\SuperAdmin\Subscriber;

use Illuminate\Foundation\Http\FormRequest;

class MailFormRequest extends FormRequest
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
            'to'=>'required',
            'subject'=>'required',
            'message'=>'required',
        ];
    }
}
