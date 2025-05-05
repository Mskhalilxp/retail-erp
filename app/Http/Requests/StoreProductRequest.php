<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('products','name')->where('store_id', $this->store_id)],
            'image'  => ['bail', 'nullable', 'file', 'mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf', 'max:4096'],
            'quantity' => ['required', 'integer', 'min:1'],
            'actual_price' => ['required', 'integer', 'min:1'],
            'sale_price' => ['required', 'integer', 'min:1', 'gt:actual_price'],
            'details' => ['nullable', 'string'],
            'store_id' => ['required', 'exists:stores,id'],
        ];
    }
}
