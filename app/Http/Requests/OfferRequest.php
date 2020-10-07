<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'img.*' => 'bail|image|required|max:3072',
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required|numeric',
            'brand_id' => 'required',
            'quantity' => 'required|numeric',
            'category_id' => 'required',
            'cf.*' => 'required',
        ];
    }
}
