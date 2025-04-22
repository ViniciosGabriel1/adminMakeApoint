<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function(){

    Route::get('/', function () {
        return view('home');
    });

    // Route::get('/clients',function (){
    //     return view('clients.index')->name('clients');
    // });
    
    Route::get('/clientes',[ClientsController::class,'index'])->name('clients');
    Route::get('/servicos',[ServicesController::class,'index'])->name('services');
});