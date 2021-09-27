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


// this routes is protected by authentication
Route::middleware('auth:api')->group(function () {

    //Uploading Routes 
    Route::prefix('uploading')->group(function () {
        Route::post('/item',                                    'API\UploadingController@uploaditem')->name('upload-item');
        Route::post('/item_price',                              'API\UploadingController@uploadprice')->name('upload-price');
        Route::post('/item_disable',                            'API\UploadingController@uploadItemDisable')->name('upload-item-disable');
        Route::post('/item_category',                           'API\UploadingController@uploadcategory')->name('upload-category');
        Route::post('/item_filename',                           'API\UploadingController@uploaditemfilename')->name('upload-item-filename');
        Route::post('/item_image',                              'API\UploadingController@multipleImage')->name('multiple-image');
        Route::post('/item_description',                        'API\UploadingController@item_description')->name('item-description');
    });
    //End Uploading Routes 

    //Chart Routes
    Route::prefix('chart')->group(function () {
        Route::get('/not_available_item',                       'API\ChartController@not_available_item')->name('not-available-item');
        Route::get('/top_items',                                'API\ChartController@top_items')->name('top-items');
        Route::get('/top_item_store',                           'API\ChartController@top_item_store')->name('top-item-store');
    });
    //End Chart Routes

    //Report Routes
    Route::prefix('report')->group(function () {

        //Report for All Store Routes
        Route::get('/item',                                     'API\ReportController@get_item')->name('get-item');
        Route::get('/liquidation',                              'API\ReportController@get_liquidation')->name('get-liquidition');
        Route::get('/accountability',                           'API\ReportController@get_accountability')->name('get-accountability');
        Route::get('/transactions',                             'API\ReportController@get_transactions')->name('get-transactions');
        Route::get('/instruction',                              'API\ReportController@get_instruction')->name('get-instruction');
        Route::get('/unfound',                                  'API\ReportController@get_unfound')->name('get-unfound');
        //End Report for All Store Routes

        //Report for per Store Routes
        Route::prefix('store')->group(function () {
            Route::get('/item_report',                          'API\ReportController@get_item_report_store')->name('get-item-report-store');
            Route::get('/liquidation',                          'API\ReportController@get_liquidation_store')->name('get-liquidition-store');
            Route::get('/accountability',                       'API\ReportController@get_accountability_store')->name('get-accoutability-store');
        });
        //End Report for per Store Routes

    });
    //End Report Routes

    Route::prefix('item')->group(function () {
        //Product/Item All Store Routes
        Route::get('/show',                                     'API\ItemController@get_item_all_store')->name('get-item-all-store');
        Route::get('/item_available_all_store/show',            'API\ItemController@item_available_all_store')->name('item-available-all-store');
        Route::post('/change_status',                           'API\ItemController@change_status_all_store')->name('change-status-all-store');
        Route::post('/image',                                   'API\ItemController@item_image')->name('item-image');
        Route::get('/category',                                 'API\ItemController@item_category')->name('item-category');
        Route::get('/disable_uom/show',                         'API\ItemController@show_item_disable_per_uom')->name('show-item-disable-per-uom');
        Route::post('/disable_uom',                             'API\ItemController@disable_item_uom')->name('disable-item-uom');
        Route::get('/enable_uom/show',                          'API\ItemController@show_item_enable_per_uom')->name('show-item-enable-per-uom');
        Route::post('/enable_uom',                              'API\ItemController@enable_item_uom')->name('enable-item-uom');
        Route::get('/change_price/count',                       'API\ItemController@change_price_count')->name('change-price-count');
        Route::get('/change_price/show',                        'API\ItemController@change_price')->name('change-price');
        //End Product/Item All Store Routes


        //Product/Item Per Store Routes
        Route::prefix('per_store')->group(function () {
            Route::get('/show',                                 'API\ItemController@get_item_per_store')->name('get-item-per-store');
            Route::get('/item_not_available_per_store/show',    'API\ItemController@item_not_available_per_store')->name('item-not-available-per-store');
            Route::post('/item_enabled',                        'API\ItemController@enabled_selected_item')->name('enabled-selected-item');
            Route::post('/item_disabled',                       'API\ItemController@disabled_selected_item')->name('disabled-selected-item');
            Route::delete('/item_tag_enabled/{itemcode}',       'API\ItemController@tag_item_enabled')->name('tag-item-disabled');
            Route::post('/item_tag_disabled',                   'API\ItemController@tag_item_disabled')->name('tag-item-enabled');
            Route::post('/change_status',                       'API\ItemController@change_status_per_store')->name('change-status-per-store');
        });
        //End Product/Item Per Store Routes
    });

    //Masterfile Setup Routes
    Route::prefix('masterfile')->group(function () {


        //Province,Town,Barangay,Transportation,Store,PriceGroup,Departments Routes
        Route::get('/province',                                 'API\SetUpController@province')->name('province');
        Route::get('/town',                                     'API\SetUpController@town')->name('town');
        Route::get('/barangay',                                 'API\SetUpController@barangay')->name('barangay');
        Route::get('/transportation',                           'API\SetUpController@transportation')->name('transportation');
        Route::get('/store',                                    'API\SetUpController@store')->name('store');
        Route::get('/price_group',                              'API\SetUpController@price_group')->name('price-group');
        Route::get('/department',                               'API\SetUpController@department')->name('department');
        //End Province,Town,Barangay,Transportation,Store,PriceGroup,Departments Routes

        //Business Rule Routes
        Route::get('/rule/show',                                'API\SetUpController@show_rules')->name('show-rules');
        Route::post('/rule/update',                             'API\SetUpController@rule_update')->name('rule-update');
        //End Business Rule Routes

        //Business Time Routes
        Route::get('/business_time/show',                       'API\SetUpController@show_business_time')->name('show-business-time');
        Route::post('/business_time/save',                      'API\SetUpController@save_business_time')->name('save-business-time');
        Route::delete('/business_time/{id}',                    'API\SetUpController@delete_business_time')->name('delete-business-time');
        Route::post('/business_time/status',                    'API\SetUpController@business_time_status')->name('business-time-active');
        //End Business Time Routes

        //Tenant Routes
        Route::get('/tenant/show',                              'API\SetUpController@show_tenant')->name('show-tenant');
        Route::post('/tenant/save',                             'API\SetUpController@save_tenant')->name('save-tenant');
        Route::delete('/tenant/{id}',                           'API\SetUpController@delete_tenant')->name('delete-tenant');
        Route::post('/tenant/update',                           'API\SetUpController@edit_tenant')->name('edit-tenant');
        //End Tenant Routes

        //Minimum Order Routes
        Route::get('/min_order/show',                           'API\SetUpController@show_min_order')->name('show-min-order');
        Route::post('/min_order/save',                          'API\SetUpController@create_minimum')->name('create-minimum');
        Route::delete('/min_order/{id}',                        'API\SetUpController@delete_minimum')->name('delete-minimum');
        Route::post('/min_order/update/',                       'API\SetUpController@edit_minimum')->name('edit-minimum');
        //End Minimum Order Routes

        //Delivery Charges Routes
        Route::get('/delivery_charge/show',                     'API\SetUpController@show_charge')->name('show-charge');
        Route::post('/delivery_charge/save',                    'API\SetUpController@create_charge')->name('create-charge');
        Route::delete('/delivery_charge/{id}',                  'API\SetUpController@delete_charges')->name('delete-charges');
        Route::post('/delivery_charge/update',                  'API\SetUpController@update_charge')->name('update-charges');
        //End Delivery Charges Routes

        //Store PriceGroup Setup Routes
        Route::get('/price_group/show',                         'API\SetUpController@show_price_group')->name('show-price-group');
        Route::post('/price_group/save',                        'API\SetUpController@save_store_price_group')->name('save-store-price-group');
        Route::delete('/price_group/{id}',                      'API\SetUpController@delete_price_group')->name('delete-price-group');
        //End Store PriceGroup Setup Routes

    });
    //End Masterfile Setup Routes

    //User Routes
    Route::prefix('user')->group(function(){
    
        Route::get('/usertype',                                 'API\UserController@usertype')->name('user-type');
        Route::get('/employees',                                'API\UserController@employees')->name('employees');

        Route::get('/show',                                     'API\UserController@get_users')->name('get-users');
        Route::post('/create',                                  'API\UserController@create_user')->name('create-user');
        Route::post('/update',                                  'API\UserController@update_user')->name('update-user');
        Route::delete('/delete/{id}',                           'API\UserController@delete_user')->name('delete-user');
        Route::post('/profile_image',                           'API\UserController@profile_image')->name('profile-mage');
        Route::post('/change_password',                         'API\UserController@change_password')->name('change-password');
        Route::post('/change_username',                         'API\UserController@change_username')->name('change-username');
        Route::post('/status',                                  'API\UserController@user_status')->name('user-statu');

    });
    //End User Routes

});

