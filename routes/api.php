<?php

use App\Http\Controllers\Services\ussdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//This is my endpoint. The gateway makes a GET request to this URL

Route::get('/v1/harold-test/ussd',[ussdService::class,'ussdScreens']);
