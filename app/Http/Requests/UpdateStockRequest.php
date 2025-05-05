<?php

namespace App\Http\Requests;

use App\Enums\StockStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
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
            'price' => ['required', 'numeric', 'min:1'],
            'delivery_price' => ['required', 'numeric', 'min:1'],
            'delivery_date' => ['required', 'date', 'after_or_equal:today'],
            'status' => ['required', Rule::in([StockStatus::not_delivered->value, StockStatus::delivered->value])],
            'products' => ['required', 'array', 'min:1'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'numeric', 'min:1'],
        ];
    }
}
