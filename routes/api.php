<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function () {
    Route::post('/upload/item', 'API\UploadingController@uploaditem')->name('upload-item');
    // Route::post('uploadpending', 'API\UploadingController@uploadPendingItem')->name('upload-pending-item');
    Route::post('/upload/price', 'API\UploadingController@uploadprice')->name('upload-price');
    // Route::post('uploaduom', 'API\UploadingController@uploaduom')->name('upload-uom');
    Route::post('/upload/disable', 'API\UploadingController@uploadItemDisable')->name('upload-item-disable');
    Route::post('/upload/category', 'API\UploadingController@uploadcategory')->name('upload-category');
    Route::post('/upload/item/filename', 'API\UploadingController@uploaditemfilename')->name('upload-item-filename');
    Route::post('/upload/multiple', 'API\UploadingController@multipleImage')->name('multiple-image');
});

Route::middleware('auth:api')->group(function () {

    Route::get('/show/store_item', 'API\ItemController@getItem')->name('get-item');

    Route::get('/show/central_item', 'API\ItemController@getCentralItem')->name('get-central-item');

    // Route::get('countitem', 'API\ItemController@countItem')->name('count-item');
    // Route::get('countprice', 'API\ItemController@countPrice')->name('count-price');
    // Route::get('countuom', 'API\ItemController@countUOM')->name('count-uom');
    // Route::put('edit_item/{id}', 'API\ItemController@edit_item')->name('edit-item');
    // Route::post('create_item', 'API\ItemController@create_item')->name('create-item');
    // Route::put('create_uom/{id}', 'API\ItemController@create_uom')->name('create-uom');
    // Route::delete('delete_item/{id}', 'API\ItemController@delete_item')->name('delete-item');

    Route::get('/item_not_available', 'API\ItemController@item_not_available')->name('item-not-available');
    Route::get('item_available_all', 'API\ItemController@item_available_all')->name('item-available-all');
    Route::delete('/store/tag_enable/{itemcode}', 'API\ItemController@tag_item_enable')->name('tag-item-disable');
    Route::post('/store/tag_disable/', 'API\ItemController@tag_item_disable')->name('tag-item-enable');
    
    Route::post('/item_active', 'API\ItemController@item_Inactive')->name('item-inactive');
    Route::post('/item_inactive', 'API\ItemController@item_Active')->name('item-active');
    Route::post('/upload/image_item', 'API\ItemController@imageitem')->name('image-item');

    Route::get('/show/item_disable_per_uom', 'API\ItemController@show_item_disable_per_uom')->name('show-item-disable-per-uom');
    Route::post('/disable_item_per_uom', 'API\ItemController@disable_item_per_uom')->name('disable-item-per-uom');

    Route::get('/show/item_enable_per_uom', 'API\ItemController@show_item_enable_per_uom')->name('show-item-enable-per-uom');
    Route::post('/enable_item_per_uom', 'API\ItemController@enable_item_per_uom')->name('enable-item-per-uom');

    
    Route::get('/price_changed/count', 'API\ItemController@price_count_changed')->name('price-count-changed');
    Route::get('/price_changed/info', 'API\ItemController@price_count_changed_info')->name('price-count-changed-info');

    Route::get('/item_count_available', 'API\ItemController@item_count_available')->name('item-count-available');
    Route::get('/count/category', 'API\ItemController@count_per_category')->name('count-per-category');

    Route::post('/store/enable_item', 'API\ItemController@enable_selected_item')->name('enable-selected-item');
    Route::post('/store/disable_item', 'API\ItemController@disable_selected_item')->name('disable-selected-item');

    Route::get('count/price_changes','API\ItemController@count_price_changes')->name('count_price_changes');
});

Route::middleware('auth:api')->group(function () {

    Route::post('/min_order_amount', 'API\SetUpController@min_order_amount')->name('min-order-amount');
    Route::post('/pickup_charge', 'API\SetUpController@pickup_charge')->name('pickup-charge');
    Route::post('/order_time_cutoff', 'API\SetUpController@order_time_cutoff')->name('order-time-cutoff');
    Route::post('/max_order', 'API\SetUpController@max_order')->name('max-order');
    Route::post('/serving_time', 'API\SetUpController@serving_time')->name('serving-time');
    
    Route::get('setup_rules', 'API\SetUpController@setup_rules')->name('setup-rules');
    Route::get('pickers', 'API\SetUpController@pickers')->name('pickers');
    Route::post('pickercreate', 'API\SetUpController@pickercreate')->name('picker-create');
    Route::get('getpicker', 'API\SetUpController@getpicker')->name('get-picker');
    Route::put('pickeredit/{id}', 'API\SetUpController@pickeredit')->name('picker-edit');
    Route::delete('deletepicker/{id}', 'API\SetUpController@deletepicker')->name('picker-delete');
    Route::get('gettimepickup', 'API\SetUpController@gettimepickup')->name('get-time-pickup');
    Route::put('pickuptime_edit/{id}', 'API\SetUpController@pickuptime_edit')->name('pickup-time-edit');

    Route::get('/business_time', 'API\SetUpController@business_time')->name('business-time');
    Route::post('/business_time/save', 'API\SetUpController@save_business_time')->name('save-business-time');
    Route::delete('/business_time/delete/{id}', 'API\SetUpController@delete_business_time')->name('delete-business-time');

    Route::post('/business_time/active', 'API\SetUpController@business_time_active')->name('business-time-active');
    Route::post('/business_time/inactive', 'API\SetUpController@business_time_inactive')->name('business-time-inactive');
    
    Route::post('/tenant/create', 'API\SetUpController@add_tenant')->name('add-tenant');
    Route::get('/tenants', 'API\SetUpController@tenants')->name('tenants');
    Route::post('/tenant/update', 'API\SetUpController@edit_tenant')->name('edit-tenant');
    Route::delete('/tenant/delete/{id}', 'API\SetUpController@delete_tenant')->name('delete-tenant');

    Route::get('/departments', 'API\SetUpController@departments')->name('departments');

    Route::post('/min_order/create', 'API\SetUpController@create_minimum')->name('create-minimum');
    Route::get('/show/min_order', 'API\SetUpController@show_min_order')->name('show-min-order');
    Route::post('/min_order/update/', 'API\SetUpController@edit_minimum')->name('edit-minimum');
    Route::delete('/min_order/delete/{id}', 'API\SetUpController@delete_minimum')->name('delete-minimum');

    Route::get('/province', 'API\SetUpController@province')->name('province');
    Route::get('/town', 'API\SetUpController@town')->name('town');
    Route::get('/barangay', 'API\SetUpController@barangay')->name('barangay');
    Route::get('/transportations', 'API\SetUpController@transportation')->name('transportation');

    Route::get('filter/towns', 'API\SetUpController@filter_town')->name('filter.towns');
    Route::get('view/towns', 'API\SetUpController@show_town')->name('view.towns');
    Route::get('view/brgy', 'API\SetUpController@show_brgy')->name('view.brgy');

    Route::get('/show/charges', 'API\SetUpController@show_charge')->name('show-charge');
    Route::post('/create/charge', 'API\SetUpController@create_charge')->name('create-charge');
    Route::delete('/charge/remove/{id}', 'API\SetUpController@delete_charges')->name('delete-charges');
    Route::get('/charge/view/{id}', 'API\SetUpController@view_by_id_charges')->name('view-by-id-charges');
    Route::post('/update/charge', 'API\SetUpController@update_charge')->name('update-charges');

    Route::post('/charge/active', 'API\SetUpController@charge_active')->name('charge-active');
    Route::post('/charge/inactive', 'API\SetUpController@charge_inactive')->name('charge-inactive');
    

    Route::get('/price_group', 'API\SetUpController@price_group')->name('price-group');
    Route::get('/show/price_group', 'API\SetUpController@show_price_group')->name('show-price-group');
    Route::post('/price_group/save', 'API\SetUpController@save_store_price_group')->name('save-store-price-group');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/stores', 'API\UserController@getStores')->name('get-stores');
    Route::get('/usertype', 'API\UserController@usertype')->name('user-type');
    Route::get('/employees', 'API\UserController@employees')->name('employees');


    Route::get('/show/users', 'API\UserController@getusers')->name('users');
    Route::post('/user/create', 'API\UserController@create_user')->name('create-user');
    Route::post('/user/update', 'API\UserController@update_user')->name('update-user');
    Route::delete('/user/delete/{id}', 'API\UserController@delete_user')->name('delete-user');
    

    Route::post('/active', 'API\UserController@active_user')->name('active-user');
    Route::post('/inactive', 'API\UserController@inactive_user')->name('inactive-user');

    Route::post('/user/profile_image', 'API\UserController@profile_image')->name('profile-mage');

    Route::post('/user/change_password', 'API\UserController@change_password')->name('change-password');
    Route::post('/user/change_username', 'API\UserController@change_username')->name('change-username');

});

Route::middleware('auth:api')->group(function () {
    Route::get('/report/store/item_report', 'API\ReportController@store_item_report')->name('store-item-report');
    Route::get('/report/item', 'API\ReportController@get_item')->name('all-item');
    Route::get('/report/liquidation', 'API\ReportController@getLiquidation')->name('get-liquidition');
    Route::get('/report/accountability', 'API\ReportController@getAccountability')->name('get-accountability');
    Route::get('/report/store/liquidation', 'API\ReportController@getLiquidation_store')->name('get-liquidition-store');
    Route::get('/report/store/accountability', 'API\ReportController@getAccountability_store')->name('get-accoutability-store');
    Route::get('/report/transactions', 'API\ReportController@getTransactions')->name('get-transactions');
});

// Route::middleware('auth:api')->group(function () {
//     Route::get('transactions/today', 'API\TransactionsController@get_transactions_today');
// 
// });
