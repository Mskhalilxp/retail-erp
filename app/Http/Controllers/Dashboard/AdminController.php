<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $data = getModelData( model: new Admin() );

            return response()->json($data);
        }

        return view('dashboard.admins.index');
    }

    public function create()
    {
        return view('dashboard.admins.create');
    }

    public function show(Admin $admin)
    {
        return view('dashboard.admins.show',compact('admin'));
    }

    public function edit(Admin $admin)
    {
        return view('dashboard.admins.edit',compact('admin'));
    }

    public function store(StoreAdminRequest $request)
    {
        $data           = $request->validated();

        if($request->hasFile('photo'))
            $data['photo'] = uploadImage( $request->file('photo') , "Admins");

        Admin::create($data);

    }

    public function update(UpdateAdminRequest $request , Admin $admin)
    {
        $data = $request->validated();

        if($request->hasFile('photo'))
        {
            deleteImage($admin->photo, 'Admins');
            $data['photo'] = uploadImage( $request->file('photo') , "Admins");
        }

        $admin->update($data);
    }


    public function destroy(Request $request, Admin $admin)
    {

        if($request->ajax())
        {
            $admin->delete();
        }
    }

    public function updateProfile(Request $request){

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'phone'    => ['required',"regex:/^(\+\d{1,3}\s?)?\(?\d{3}\)?[\s.-]?\d{3,5}[\s.-]?\d{4,5}$/",'unique:admins,id,' . auth('admin')->id()],
            'email'    => ['required','string','email','unique:admins,id,' . auth('admin')->id() ],
            'photo'    => ['nullable','mimes:jpeg,jpg,png,gif,svg' , 'max:10000'] ,
        ]);

        if ( $request->hasFile('photo') )
        {
            deleteImage(auth('admin')->user()->photo, 'Admins');
            $data['photo'] = uploadImage( $request->file('photo') , 'Admins' );
        }

        auth('admin')->user()->update($data);

    }
    public function updatePassword(Request $request){

        $data = $request->validate([
            'password'              => ['required','string','min:6','max:255','confirmed'],
            'password_confirmation' => ['required','same:password'],
        ]);

        auth('admin')->user()->update($data);

    }

}
