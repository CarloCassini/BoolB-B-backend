<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApartmentController;


use App\Models\Apartment;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//  creiamo la rotta dandogli la risposta in _Json_

Route::apiResource("/apartments", ApartmentController::class)->only("index", "show");


// provo a tirare fuori qualcosa
Route::get("/apartments/service/{service_id}", [ApartmentController::class, "ApartmentByService"]);