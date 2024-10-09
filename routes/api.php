<?php

use App\Http\Controllers\ApiControllers\PurchaseController;
use App\Http\Controllers\ApiControllers\cryptoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\purchaseController;
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


// Route::middleware('api')->get('/demo', function () {
//     echo "hii sourabh bhaiya";
// }); 

Route::middleware(['middleware' => 'api'])->group(function () {
    // Currency table data CRUD 
    Route::post('/currencyName', [cryptoController ::class, 'store']);


    // Purchase table data CRUD 
    Route::post('/purchased-data', [PurchaseController::class, 'store']);
    Route::get('/purchased-data', [PurchaseController::class, 'get']);
    Route::put('/purchase-data-update/{id}', [PurchaseController::class, 'update']);
    Route::put('/purchase-data-delete/{id}', [PurchaseController::class, 'delete']);

    // Other routes can go here if needed
});
