<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;
use App\Model\Product;

class cartRequest extends FormRequest
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
        $product = Product::where('id', $this->productId)->first();

        return [
            'quantity' => "required|Numeric|min:1|max:$product->quantity",
        ];
    }
}
