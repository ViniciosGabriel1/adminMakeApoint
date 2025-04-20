<?php

use App\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function(){

    Route::get('/', function () {
        return view('home');
    });

    // Route::get('/clients',function (){
    //     return view('clients.index')->name('clients');
    // });
    
    Route::get('/clientes',[ClientsController::class,'index'])->name('clients');
});