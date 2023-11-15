<?php

namespace App\Http\Requests\SuperAdmin\Banner;

use Illuminate\Foundation\Http\FormRequest;

class VideoBannerRequest extends FormRequest
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
            'video_banner'=>'sometimes|mimes:mp4|max:500000',
        ];
    }
}
