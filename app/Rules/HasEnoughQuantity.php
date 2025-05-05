<?php

namespace App\Rules;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class HasEnoughQuantity implements Rule
{
    protected $maxQuantity;
    protected $orderId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id = null)
    {
        $this->orderId = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // $attribute is like "products.0.quantity"
        // We need to extract the index (0)
        $parts = explode('.', $attribute);
        $index = $parts[1] ?? null;

        if ($index === null) {
            return false;
        }

        $productId = request()->input("products.$index.id");

        if (!$productId) {
            return false;
        }

        $product = Product::find($productId);

        if (!$product) {
            return false;
        }

        if($this->orderId)
        {
            $order = Order::find($this->orderId);

            if (!$order) {
                return false;
            }
            $this->maxQuantity = $product->quantity + $order->products()->where('product_id', 1)->first()->pivot->quantity;
        }
        else
            $this->maxQuantity = $product->quantity;


        return $this->maxQuantity >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("Maximum quantity is: ") . $this->maxQuantity;
    }
}
