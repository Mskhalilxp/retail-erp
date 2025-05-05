<?php

use Illuminate\Support\Facades\Route;

Route::get('/language/{lang}', function ($lang) {

    session()->put('locale', $lang);
    return redirect()->back();

})->name('change-language');

Route::group(['namespace' => 'Auth' , 'middleware' => 'set_locale'] , function () {
    // admin login routes
    Route::get('admin/login','AdminAuthController@showLoginForm')->name('admin.login-form');
    Route::post('admin/login','AdminAuthController@login')->name('admin.login');
    Route::post('admin/logout','AdminAuthController@logout')->name('admin.logout');
});
Route::redirect('/', '/dashboard');
