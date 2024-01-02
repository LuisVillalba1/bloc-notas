<?php

use App\Http\Controllers\Block;
use App\Http\Controllers\Ingresar;
use App\Http\Controllers\RecuperateAccount;
use App\Models\Bloc;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/error",function(){
    return view("errorPage");
})->name("error");

//controlador para ingresar a el block de notas
Route::controller(Ingresar::class)->group(function(){
    Route::get("/","index")->name("main");
    Route::post("/login","login")->name("login");

    Route::get("/register","register")->name("register");
    Route::post("/register","registerCreate")->name("register.create"); 

});

// controlador para recuperar la cuenta
Route::controller(RecuperateAccount::class)->group(function(){
    Route::get("/forgotPassword","index")->name("forgotPassword");
    Route::post("/forgotPassword","sendRecoveryLink")->name("recuperateAccount");

    Route::get("/changePassword/{id}","showChangePassword")->name("changePassword")->middleware("signed");
    Route::put("/changePassword/{id}","changePassword")->name("changePasswordPut")->middleware("signed");
});

//controlador con un middleware para el block de notas
Route::middleware(['authSession'])->group(function () {
    Route::get('/miBlock', [Block::class, 'index'])->name('mainBlock');
    Route::post("/miBlock/create",[Block::class,"create"])->name("createNote");
    Route::delete("miBlock/delete/{id}",[Block::class,"delete"])->name("deleteNote");
    Route::put("miBlock/edit/{id}",[Block::class,"edit"])->name("editNote");
});