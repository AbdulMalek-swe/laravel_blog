<?php

use App\Http\Controllers\blog\BlogController;
use App\Http\Controllers\user\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("auth/signup", [UserController::class, "signup"]);
Route::post("auth/login", [UserController::class, "login"]);
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get("auth/getme", [UserController::class, "getMe"]);
});
Route::get('/user', function (Request $request) { 
    return $request->user();
});
Route::get("/blog", [BlogController::class, "index"]);
Route::get("/blog", [BlogController::class, "show"]);
Route::get("/blog/{id}", [BlogController::class, "singleBlog"]);
Route::patch("/blog/{id}", [BlogController::class, "update"]);
Route::delete("/blog/{id}", [BlogController::class, "destroy"]);
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post("/create/blog", [BlogController::class, "store"]);
});

 

   