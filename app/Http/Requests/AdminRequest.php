<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
        $classAndMethod = explode('@', $this->route()->getActionName());
        $method = $classAndMethod[1];

        switch ($method) {
        case 'store':
            return [
                'name' => 'required',
                'email' => 'required|E-Mail|unique:admins',
                'password' => 'required',
            ];
            break;
        case 'update':
            return [
                'name' => 'required',
                'email' => 'required|E-Mail',Rule::unique('admins')->ignore($this->route('id')),
                'password' => 'required',
            ];
            break;
        default:
            break;
        }
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
        ];
    }
}
