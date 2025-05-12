<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ManageWhatsappController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ServicesController;
use App\Mail\ScheduleEmail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;



Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('home');
    });

    // Route::get('/clients',function (){
    //     return view('clients.index')->name('clients');
    // });

    Route::get('/clientes', [ClientsController::class, 'index'])->name('clients');
    // Route::get('/clientes', \App\Livewire\Clients::class)->name('clients')->lazy();

    Route::get('/servicos', [ServicesController::class, 'index'])->name('services');
    Route::get('/agendamentos', [ScheduleController::class, 'index'])->name('schedules');
    Route::get('gerenciar-whatsapp',[ManageWhatsappController::class,'index'])->name('manage-whatsapp');
    });

    // Route::post('/webhook/whatsapp', [WebhookController::class, 'handle']);


Route::get('/teste-email', function () {
    $mensagem = "Olá! Este é um e-mail de teste enviado usando o SMTP do Gmail com Laravel.";

    Mail::to('vshow319@gmail.com')->send(new ScheduleEmail($mensagem));

    return 'E-mail enviado com sucesso!';
});

// Route::post('/api/webhook/baileys', [WebhookController::class, 'handle']);
