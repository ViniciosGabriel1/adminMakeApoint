<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\RemindSchedulesUserMail;
use App\Models\Schedules;
use Carbon\Carbon;

class CommandSendingRemindUser extends Command
{
    protected $signature = 'lembrete:teste';
    protected $description = 'Envia um e-mail de lembrete fictício para testes';

    public function handle()
    {

        $hoje = Carbon::today()->toDateString();
        $agendamentos = Schedules::whereDate('data', $hoje)->with('cliente')->with('servicos')->get();
        $email = config('mail.from.address');

        if ($agendamentos->isEmpty()) {
            $this->info('Nenhum agendamento encontrado para hoje.');
            return;
        }
        
        $dadosReais = [
            'data' => Carbon::parse($hoje)->format('d/m/Y'),
            'agendamentos' => $agendamentos->map(function ($item) {
                return [
                    'cliente_nome' => $item->cliente->name ?? 'Cliente',
                    'hora' => $item->hora,
                    'observacoes' => $item->observacoes,
                    'servicos' => $item->servicos->map(function ($servico) {
                        return [
                            'nome' => $servico->title,
                            'preco' => number_format($servico->value, 2, ',', '.'),
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];
        
        Mail::to($email)->send(new RemindSchedulesUserMail($dadosReais));
        $this->info('E-mail de lembrete REAL enviado com sucesso para ' . $email);
    }
}
