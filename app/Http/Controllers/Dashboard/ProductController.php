<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!isSuperAdmin(), 403);
        if ($request->ajax())
        {
            $data = getModelData( model: new Product(), relations: ['store' => ['id','name']] );

            return response()->json($data);
        }

        return view('dashboard.products.index');
    }

    public function create()
    {
        abort_if(!isSuperAdmin(), 403);
        return view('dashboard.products.create');
    }


    public function show(Product $product)
    {
        return view('dashboard.products.show',compact('product'));
    }

    public function edit(Product $product)
    {
        abort_if(!isSuperAdmin(), 403);
        return view('dashboard.products.edit',compact('product'));
    }

    public function store(StoreProductRequest $request)
    {
        abort_if(!isSuperAdmin(), 403);
        $data = $request->validated();

        if($request->file('image'))
            $data['image'] = uploadImage($request->file('image'), "Products/" . $data['store_id']);

        Product::create($data);

    }

    public function update(UpdateProductRequest $request , Product $product)
    {
        abort_if(!isSuperAdmin(), 403);
        $data = $request->validated();

        if($request->file('image'))
        {
            deleteImage($product->image, "Products/" . $data['store_id']);
            $data['image'] = uploadImage($request->file('image'), "Products/" . $data['store_id']);
        }

        $product->update($data);
    }


    public function destroy(Request $request, Product $product)
    {
        abort_if(!isSuperAdmin(), 403);
        if($request->ajax())
        {
            $product->delete();
        }
    }
}
