<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MerchantDashboardController;
use App\Http\Controllers\MerchantRegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MerchantProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PackageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect()->route('merchant.login');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth','admin']], function () {
    
    Route::get('/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    Route::get('/merchants',[AdminController::class,'users'])->name('admin.users');
    Route::get('/update/approval/{userId}',[AdminController::class,'updateApproval'])->name('admin.updateApproval');
    Route::get('/merchant/details/{userId}',[AdminController::class,'merchantDetails'])->name('admin.merchantDetails');
    Route::post('/merchant/details/update/{userId}',[AdminController::class,'update'])->name('admin.merchant.update');
    Route::get('/merchant/delete/{userId}',[AdminController::class,'destroy'])->name('admin.user.delete');

    Route::get('/packages',[PackageController::class,'index'])->name('admin.package.index');
    Route::get('/packages/create',[PackageController::class,'create'])->name('admin.package.create');
    Route::post('/packages/store',[PackageController::class,'store'])->name('admin.package.store');
    Route::post('/packages/update/{packageId}',[PackageController::class,'update'])->name('admin.package.update');
    Route::get('/packages/edit/{packageId}',[PackageController::class,'edit'])->name('admin.package.edit');
    Route::get('/packages/delete/{packageId}',[PackageController::class,'destroy'])->name('admin.package.destroy');

    Route::get('/stores/index','App\Http\Controllers\Admin\StoreController@index')->name('admin.store.index');
    Route::get('/stores/create','App\Http\Controllers\Admin\StoreController@create')->name('admin.store.create');
    Route::post('/stores/store','App\Http\Controllers\Admin\StoreController@store')->name('admin.store.store');
    Route::get('/stores/edit/{store}','App\Http\Controllers\Admin\StoreController@edit')->name('admin.store.edit');
    Route::post('/stores/update/{store}','App\Http\Controllers\Admin\StoreController@update')->name('admin.store.update');
    Route::get('/delete/{storeId}', 'App\Http\Controllers\Admin\StoreController@destroy')->name('admin.store.destroy');
    Route::get('/change/status/{store}', 'App\Http\Controllers\Admin\StoreController@chnageStatus')->name('admin.store.chnageStatus');


    Route::get('/order/index', 'App\Http\Controllers\Admin\OrderController@index')->name('admin.order.index');
    Route::get('/order/create', 'App\Http\Controllers\Admin\OrderController@create')->name('admin.order.create');
    Route::post('/order/store', 'App\Http\Controllers\Admin\OrderController@store')->name('admin.order.store');
    Route::get('/order/edit/{orderId}', 'App\Http\Controllers\Admin\OrderController@edit')->name('admin.order.edit');
    Route::post('/order/update/{orderId}', 'App\Http\Controllers\Admin\OrderController@update')->name('admin.order.update');
    Route::get('/order/delete/{orderId}', 'App\Http\Controllers\Admin\OrderController@destroy')->name('admin.order.destroy');
    

    
    Route::get('/getStore/{userId}', 'App\Http\Controllers\Admin\OrderController@getStore');
});


//login controller
Route::get('/merchant/log-in',[LoginController::class, 'index'])->name('merchant.login');
Route::post('/merchant/authenticate',[LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/merchant/log-out',[LoginController::class, 'logout'])->name('merchant.logout');

// merchant register route
Route::get('merchant/register',[MerchantRegisterController::class, 'create'])->name('merchant.register');
Route::post('merchant/store',[MerchantRegisterController::class, 'store'])->name('merchant.store');

// Route::get('/', [MerchantDashboardController::class, 'index']);

// store routes
Route::group(['prefix' => 'merchant/store','middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/index', [StoreController::class, 'index'])->name('store.index');
    Route::get('/create', [StoreController::class, 'create'])->name('store.create');
    Route::post('/store', [StoreController::class, 'store'])->name('store.store');
    Route::get('/edit/{store}', [StoreController::class, 'edit'])->name('store.edit');
    Route::post('/update/{store}', [StoreController::class, 'update'])->name('store.update');
    Route::get('/change-status/{store}', [StoreController::class, 'chnageStatus'])->name('store.chnageStatus');
});


//order routes
Route::group(['prefix' => 'merchant/order','middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/index', [OrderController::class, 'index'])->name('order.index');
    Route::get('/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/view/{orderId}', [OrderController::class, 'view'])->name('order.view');
    Route::get('/invoice/{orderId}', [OrderController::class, 'invoice'])->name('order.invoice');
    Route::get('/pdf/{orderId}', [OrderController::class, 'pdf'])->name('order.invoice_pdf');
});


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    
    Route::get('/getZone/{cityId}', [StoreController::class, 'getZone']);
    Route::get('/getArea/{zoneId}', [StoreController::class, 'getArea']);

    //order search rooutes
    Route::get('/merchant/order/search-store/{searchKey}', [OrderController::class, 'searchByStore']);
    Route::get('/merchant/order/search-name/{searchKey}', [OrderController::class, 'searchByName']);
    Route::get('/merchant/order/search-id/{searchKey}', [OrderController::class, 'searchById']);
    Route::get('/merchant/order/search-date/{searchKey}', [OrderController::class, 'searchByDate']);
    Route::get('/merchant/order/search-payment/{searchKey}', [OrderController::class, 'searchByPayment']);
});

Route::get('/admin/search-package/{searchKey}', [AdminController::class,'searchByPackage']);
Route::get('/admin/search-id/{searchKey}', [AdminController::class,'searchById']);
Route::get('/admin/search-name/{searchKey}', [AdminController::class,'searchByName']);
Route::get('/admin/search-email/{searchKey}', [AdminController::class,'searchByEmail']);
Route::get('/admin/search-approved/{searchKey}', [AdminController::class,'searchByApproval']);
// Route::get('/admin/search-user/${packageId}', [AdminController::class,'searchByPackage']);
// Route::get('/admin/search-user/${packageId}', [AdminController::class,'searchByPackage']);
// Route::get('/admin/search-user/${packageId}', [AdminController::class,'searchByPackage']);

Route::get('/merchant/profile-update', function () {
    return view('merchant.profile.update');
});
Route::get('/merchant/profile/edit/{merchantId}',[MerchantProfileController::class,'edit'])->name('merchantProfile.edit');
Route::post('/merchant/profile/update/{merchantId}',[MerchantProfileController::class,'update'])->name('merchantProfile.update');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',[MerchantDashboardController::class, 'index'])->name('dashboard');
