<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'email' => 'required|E-Mail',
            'fb' => 'required|URL',
            'tw' => 'required|URL',
            'yt' => 'required|URL',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'The :attribute is required.',
            'E-Mail' => 'The :attribute is not valid Email.',
            'URL' => 'The :attribute is not valid URL.',
        ];
    }
}
