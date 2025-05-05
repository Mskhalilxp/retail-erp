<?php

namespace App\Http\Requests;

use App\Rules\HasEnoughQuantity;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
        $id = $this->route('order')->id;
        return [
            'client_name' => ['nullable', 'string', 'max:255'],
            'client_mobile' => ['required', 'regex:/^[0][7]\d{9}$/u'],
            'city.id' => ['required', 'integer', 'min:1'],
            'city.name' => ['required', 'string'],
            'region.id' => ['required', 'integer', 'min:1'],
            'region.name' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'discount' => ['nullable', 'integer'],
            'preparation_date' => ['required', 'date', 'after_or_equal:today'],
            'client_notes' => ['nullable', 'string'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.id' => ['required', 'exists:products,id', 'distinct'],
            'products.*.quantity' => ['required', 'integer', 'min:1', new HasEnoughQuantity($id)],
        ];
    }
}
