<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;

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

//utvonalak

Route::post("/register", [AuthController::class, "signUp"]);
Route::post("/login",[AuthController::class,"signIn"]);
//utvonal ami betölt minden bejegyzést
Route::get("/blogs", [BlogController::class,"index"]);
//utvonal ami eltárol mindent
Route::post("/blogs",[BlogController::class,"store"]);
//1darab bejegyzést mutatja meg, {amit beirunk az url-be}
Route::get("/blog/{id}",[BlogController::class, "show"]);
//update, alapbol nincs put meg delete, de itt lehet használni
Route::put("/blog/{id}",[BlogController::class,"update"]);
//delete
Route::delete("/blog/{id}", [BlogController::class, "destroy"]);