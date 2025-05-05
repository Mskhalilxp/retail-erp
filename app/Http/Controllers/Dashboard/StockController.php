<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Stock;
use App\Models\Product;
use App\Enums\StockStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;

class StockController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!isSuperAdmin(), 403);
        if ($request->ajax())
        {
            $data = getModelData( model: new Stock() );

            return response()->json($data);
        }

        return view('dashboard.stocks.index');
    }

    public function create()
    {
        abort_if(!isSuperAdmin(), 403);
        return view('dashboard.stocks.create');
    }


    public function show(Stock $stock)
    {
        abort_if(!isSuperAdmin(), 403);
        return view('dashboard.stocks.show',compact('stock'));
    }

    public function edit(Stock $stock)
    {
        abort_if(!isSuperAdmin(), 403);

        if($stock->status == StockStatus::delivered->value)
            return view('dashboard.stocks.show', compact('stock'));
        return view('dashboard.stocks.edit',compact('stock'));
    }

    public function store(StoreStockRequest $request)
    {
        abort_if(!isSuperAdmin(), 403);

        $data = $request->validated();
        $stock = Stock::create($data);

        foreach($data['products'] as $productData)
        {
            $stock->products()->attach($productData['id'], ['quantity' => $productData['quantity']]);
            if($stock->status == StockStatus::delivered->value)
            {
                $product = Product::find($productData['id']);
                $product->update(['quantity' => $product->quantity + $productData['quantity']]);
            }
        }
    }

    public function update(UpdateStockRequest $request , Stock $stock)
    {
        abort_if(!isSuperAdmin(), 403);
        $data = $request->validated();
        $stock->update($data);
        $stock->products()->sync([]);

        foreach($data['products'] as $productData)
        {
            $stock->products()->attach($productData['id'], ['quantity' => $productData['quantity']]);
            if($stock->status == StockStatus::delivered->value)
            {
                $product = Product::find($productData['id']);
                $product->update(['quantity' => $product->quantity + $productData['quantity']]);
            }
        }
    }


    public function destroy(Request $request, Stock $stock)
    {
        abort_if(!isSuperAdmin(), 403);
        if($request->ajax())
            $stock->delete();
    }
}
