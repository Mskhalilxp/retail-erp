<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!isSuperAdmin(), 403);
        if ($request->ajax())
        {
            $data = getModelData( model: new Store() );

            return response()->json($data);
        }

        return view('dashboard.stores.index');
    }

    public function create()
    {
        abort_if(!isSuperAdmin(), 403);
        return view('dashboard.stores.create');
    }


    public function show(Store $store)
    {
        abort_if(!isSuperAdmin(), 403);
        $products = $store->products()->paginate(10, pageName:'products-page');
        return view('dashboard.stores.show', get_defined_vars());
    }

    public function edit(Store $store)
    {
        abort_if(!isSuperAdmin(), 403);
        return view('dashboard.stores.edit', get_defined_vars());
    }

    public function store(StoreStoreRequest $request)
    {
        abort_if(!isSuperAdmin(), 403);
        $data = $request->validated();

        if($request->file('logo'))
            $data['logo'] = uploadImage($request->file('logo'), 'Stores');

        Store::create($data);

    }

    public function update(UpdateStoreRequest $request , Store $store)
    {
        abort_if(!isSuperAdmin(), 403);
        $data = $request->validated();

        if($request->file('logo'))
        {
            deleteImage($store->logo, 'Stores');
            $data['logo'] = uploadImage($request->file('logo'), 'Stores');
        }

        $store->update($data);
    }


    public function destroy(Request $request, Store $store)
    {
        abort_if(!isSuperAdmin(), 403);
        if($request->ajax())
        {
            $store->delete();
        }
    }
}
