<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\RegionController;
use Illuminate\Support\Facades\Http;

Route::group([ 'prefix' => 'dashboard' , 'namespace' => 'Dashboard', 'as' => 'dashboard.' , 'middleware' => ['web', 'auth:admin', 'set_locale' ] ] , function (){

    /** set theme mode ( light , dark ) **/
    Route::get('/change-theme-mode/{mode}', function ($mode) {

        session()->put('theme_mode', $mode);
        return redirect()->back();

    });

    /** dashboard index **/
    Route::get('/' , 'DashboardController@index')->name('index');

    /** resources routes **/
    Route::resource('admins','AdminController');
    Route::resource('stores','StoreController');
    Route::resource('products','ProductController');
    Route::resource('campaigns','CampaignController')->except('show');
    Route::resource('stocks','StockController');
    Route::resource('orders','OrderController');
    Route::post('orders/{order}/change-status', 'OrderController@changeStatus')->name('orders.change_status');

    Route::resource('settings','SettingController')->only(['index','store']);

    /** admin profile routes **/
    Route::view('edit-profile','dashboard.admins.edit-profile')->name('edit-profile');
    Route::put('update-profile', 'AdminController@updateProfile')->name('update-profile');
    Route::put('update-password', 'AdminController@updatePassword')->name('update-password');

    /** notifications routes **/
    Route::post('/save-token', 'NotificationController@saveToken')->name('save-token');
    Route::post('/send-notification', 'NotificationController@sendNotification')->name('send.notification');
    Route::get('notifications/{id}/mark_as_read', 'NotificationController@markAsRead')->name('notifications.mark_as_read');
    Route::get('notifications/{type}/load-more/{next}', 'NotificationController@loadMore')->name('notifications.load_more');
    Route::get('notifications/mark-all-as-read', 'NotificationController@markAllAsRead')->name('notifications.mark_all_as_read');

});

Route::get('/notify', function(){
    $admins = App\Models\Admin::whereIn('id', [1])->get();
    storeAndPushNotification($admins, 'test notification', 'testing sending notification to admin', route('dashboard.admins.show', auth('admin')->id()));
});

Route::get('city/{id}/regions', function($id){
    return Http::get('https://api.alwaseet-iq.net/v1/merchant/regions?city_id='.$id)->json()['data'];
});
