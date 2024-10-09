<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Crypto\CryptoController;
use App\Http\Controllers\Backend\Accounting\PurchaseController;
use App\Http\Controllers\Backend\Accounting\SaleController;
use App\Http\Controllers\Backend\CsvImportController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::get('/crypto_balance', 'Backend\Accounting\PurchaseController@show_accountingPurchase')->name('admin.purchaseBalance');
    Route::get('/current_rate', 'Backend\Accounting\PurchaseController@current_rate')->name('admin.current_rate');
    Route::get('/profit-loss', 'Backend\Accounting\PurchaseController@profit_loss')->name('admin.profit-loss');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);
    // Route::get('/purchase', function () {
    //     return view('purchase');
    // });

    // Crypto controller  
    Route::resource('crypto', CryptoController::class)->names('crypto');
    // Route::resource('cryptoApi', CryptoController::class)->names('cryptoApi');
    
    // Accounting controller  
    Route::resource('accountingPurchase', PurchaseController::class)->names('accountingPurchase');
    Route::resource('accountingSale', SaleController::class)->names('accountingSale');
    Route::post('get-currency-balance/', 'Backend\Accounting\SaleController@getCurrencyBalance');


//  CSV purchase and sale 

    Route::get('/import', function () {
        return view('backend.pages.import');
    })->name('import.form');
    
    Route::get('/import', [CsvImportController::class, 'index'])->name('import');
    Route::post('/import-csv', [CsvImportController::class, 'importCsv'])->name('import.csv');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');
});
    Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');


    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');

});