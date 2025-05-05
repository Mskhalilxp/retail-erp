<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\EmployeeRole;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $andsFilters = [];
            $orsFilters = [];

            if(auth('admin')->user()->role == EmployeeRole::social_media->value)
            {
                $orsFilters[] = ['status', OrderStatus::created->value];
                $orsFilters[] = ['status', OrderStatus::delivered->value];
                $orsFilters[] = ['status', OrderStatus::returned->value];
            }

            if(auth('admin')->user()->role == EmployeeRole::warehouse->value)
            {
                $orsFilters[] = ['status', OrderStatus::created->value];
                $orsFilters[] = ['status', OrderStatus::prepared->value];
                $orsFilters[] = ['status', OrderStatus::delivered->value];
            }

            $data = getModelData( model: new Order(), relations: ['socialEmployee' => ['id','name', 'role'], 'warehouseEmployee' => ['id','name', 'role'], 'contactEmployee' => ['id','name', 'role'],], andsFilters: $andsFilters, orsFilters: $orsFilters );

            return response()->json($data);
        }

        $admins = Admin::all();
        return view('dashboard.orders.index', get_defined_vars());
    }

    public function create()
    {
        abort_if(!isSocialMedia(), 403);

        $cities = Http::get('https://api.alwaseet-iq.net/v1/merchant/citys')->json()['data'];

        return view('dashboard.orders.create', get_defined_vars());
    }

    public function show(Order $order)
    {
        if(!isSuperAdmin())
        {
            abort_if(auth('admin')->user()->role == EmployeeRole::social_media->value && $order->status != OrderStatus::created->value && $order->status != OrderStatus::delivered->value && $order->status != OrderStatus::returned->value, 403);

            abort_if(auth('admin')->user()->role == EmployeeRole::warehouse->value && $order->status != OrderStatus::created->value && $order->status != OrderStatus::prepared->value && $order->status != OrderStatus::delivered->value, 403);
        }

        return view('dashboard.orders.show',compact('order'));
    }

    public function edit(Order $order)
    {
        abort_if(!isSocialMedia() || $order->status != OrderStatus::created->value, 403);

        $cities = Http::get('https://api.alwaseet-iq.net/v1/merchant/citys')->json()['data'];
        return view('dashboard.orders.edit', get_defined_vars());
    }

    public function store(StoreOrderRequest $request)
    {
        abort_if(!isSocialMedia(), 403);
        $data = $request->validated();
        $data['items_number'] = count($data['products']);
        $data['discount'] = $data['discount'] ?? 0; // Force default value
        $data['client_mobile'] = '+964' . substr($data['client_mobile'],1);
        $order = Order::create($data);
        $totalSalePrice = 0;
        $totalActualPrice = 0;
        $typeName = '';

        foreach($data['products'] as $productData)
        {
            $product = Product::find($productData['id']);
            $order->products()->attach($productData['id'], [
                'quantity' => $productData['quantity'],
                'sale_price' => $product->sale_price,
                'actual_price' => $product->actual_price
            ]);

            $product->update(['quantity' => $product->quantity - $productData['quantity']]);
            $totalSalePrice += $product->sale_price * $productData['quantity'];
            $totalActualPrice += $product->actual_price * $productData['quantity'];
            $typeName .= $product->name . ', ';
        }

        $order->update(['sale_price' => $totalSalePrice - $order->discount, 'actual_price' => $totalActualPrice, 'type_name' => $typeName]);
    }

    public function update(UpdateOrderRequest $request , Order $order)
    {
        abort_if(!isSocialMedia() || $order->status != OrderStatus::created->value, 403);
        $data = $request->validated();
        $data['items_number'] = count($data['products']);
        $data['discount'] = $data['discount'] ?? 0; // Force default value
        $data['client_mobile'] = '+964' . substr($data['client_mobile'],1);
        $order->update($data);
        $totalSalePrice = 0;
        $totalActualPrice = 0;
        $typeName = '';

        $order->products()->detach();
        foreach($data['products'] as $productData)
        {
            $product = Product::find($productData['id']);
            $order->products()->attach($productData['id'], [
                'quantity' => $productData['quantity'],
                'sale_price' => $product->sale_price,
                'actual_price' => $product->actual_price
            ]);

            $product->update(['quantity' => $product->quantity - $productData['quantity']]);
            $totalSalePrice += $product->sale_price * $productData['quantity'];
            $totalActualPrice += $product->actual_price * $productData['quantity'];
            $typeName .= $product->name . ', ';
        }

        $order->update(['sale_price' => $totalSalePrice - $order->discount, 'actual_price' => $totalActualPrice, 'type_name' => $typeName]);
    }

    public function destroy(Request $request, Order $order)
    {
        abort_if(!isSuperAdmin(), 403);
        if($request->ajax())
            $order->delete();
    }

    public function changeStatus(Request $request, Order $order)
    {
        // dd($request->all(), $order);
        $request->validate([
            'status' => ['required', 'in:prepared,delivered,returned,client_contacted']
        ]);

        if($request->status == 'prepared')
        {
            abort_if( !isWarehouse(),403);
            $response = Http::asForm()->post('https://api.alwaseet-iq.net/v1/merchant/create-order?token=' . settings()->get('login_token'),
                    [
                        'client_name' => $order->client_name,
                        'client_mobile' => $order->client_mobile,
                        'city_id' => $order->city['id'],
                        'region_id' => $order->region['id'],
                        'location' => $order->address,
                        'type_name' => $order->type_name,
                        'items_number' => $order->items_number,
                        'price' => $order->sale_price,
                        'package_size' => 1,
                        'merchant_notes' => $order->client_notes,
                        'replacement' => 0,
                    ])->json();

            if(!$response['status'])
                throw ValidationException::withMessages(['status' => $response['msg']]);
            else
            {
                $order->update([
                    'prepared_by' => auth('admin')->user()->id,
                    'qr_id' => $response['data']['qr_id'],
                    'shipping_price' => $response['data']['company_price']
                ]);
            }
        }
        else if($request->status == 'delivered')
        {
            abort_if( !isWarehouse(),403);
            $order->update([
                'delivery_date' => date('Y-m-d'),
                'warehouse_notes' => $request->warehouse_notes
            ]);
        }
        else if($request->status == 'returned')
        {
            abort_if( !isWarehouse(),403);
            $request->validate([
                'warehouse_notes' => ['required', 'string'],
                'products' => ['required', 'array', 'min:1'],
                'products.*.id' => ['required', 'exists:products,id', 'distinct'],
                'products.*.quantity' => ['required', 'numeric', 'min:0'],
            ]);

            $totalSalePrice = $order->sale_price;
            $totalActualPrice = $order->actual_price;

            $isThereReturnedQuantity = 0;

            foreach($request->products as $index => $productData)
            {
                $product = Product::find($productData['id']);
                $orderProduct = $order->products->where('id', $productData['id'])->first();

                if($productData['quantity'] > $orderProduct->pivot->quantity)
                    throw ValidationException::withMessages(["products.$index.quantity" => __("Return quantity must be less than ordered quantity")]);
                else if($productData['quantity'] < $orderProduct->pivot->quantity)
                    $isThereReturnedQuantity = 1;

                if(!$isThereReturnedQuantity)
                    throw ValidationException::withMessages(["return_quantity" => __("There is no returned quantity")]);

                $diffInQuantity = $orderProduct->pivot->quantity - $productData['quantity'];
                $product->update(['quantity' => $product->quantity + $diffInQuantity]);

                $totalSalePrice -=  $diffInQuantity * $orderProduct->pivot->sale_price;
                $totalActualPrice -=  $diffInQuantity * $orderProduct->pivot->actual_price;

                $order->products()->updateExistingPivot($productData['id'], ['quantity' => $productData['quantity']]);
            }

            $order->update([
                'sale_price' => $totalSalePrice,
                'actual_price' => $totalActualPrice,
                'warehouse_notes' => $request->warehouse_notes,
                'delivery_date' => date('Y-m-d'),
            ]);
        }
        else if($request->status == 'client_contacted')
        {
            abort_if( !isSocialMedia(),403);
            $request->validate([
                'client_notes' => ['required', 'string'],
            ]);
            $order->update([
                'client_notes' => $request->client_notes,
                'client_contacted_by' => auth('admin')->user()->id
            ]);
        }



        $order->update(['status' => OrderStatus::fromCase($request->status)]);
    }
}
