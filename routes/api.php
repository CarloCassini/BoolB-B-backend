<?php

use App\Http\Controllers\API\ServicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\TomtomController;
use App\Http\Controllers\Api\SponsorController;
use App\Http\Controllers\Api\MessageController;


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

// * APARTMENT API --------------------------------------------------------------------------
// Route::apiResource("/apartments", ApartmentController::class)->only("index", "show");
Route::apiResource("/apartments", ApartmentController::class);
Route::get("/apartments/service/{service_id}", [ApartmentController::class, "ApartmentByService"]);
Route::post("/apartments-by-filters", [ApartmentController::class, "ApartmentsByFilters"]);
Route::get("/sponsored", [ApartmentController::class, "sponsored"]);

// * SERVICE API ----------------------------------------------------------------------------
Route::apiResource("/services", ServicesController::class)->only("index");

// *TOMTOM API ------------------------------------------------------------------------------
//ricerco api per il tomtom con guzzle
Route::get('/tomtom/{address}', [TomtomController::class, "findsuggest"]);

// MESSAGE API -------------------------------------------------------------------------------

Route::apiResource("/message", MessageController::class);

// payment api -------------------------------------------------------------------------------
// https://www.youtube.com/watch?v=1-Ge9IqbwNY
// minuto 41:00
Route::get('/sponsors/generate', [SponsorController::class, "generate"]);
Route::post('/sponsors/makePayment', [SponsorController::class, "makePayment"])->name('api.sponsors.makePayment');