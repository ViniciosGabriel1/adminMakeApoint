<?php

namespace App\Livewire;

use App\Models\Clients;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\Schedules as ModelsSchedules;
use Twilio\Rest\Client;


class Calendar extends Component
{
    public $currentDate;
    public $days = [];
    public $events = [];
    public $selectedDate = null;
    public $showDayModal = false;

    public function mount()
    {
        $this->currentDate = Carbon::now();
        $this->selectedDate = Carbon::now()->format('Y-m-d');

        // Carrega os eventos antes de gerar o calendário
        $this->loadEvents();
        $this->generateCalendar();
    }


    public function msg($event)
    {
        $eventArray = json_decode($event, true);
    
        $messagem = "🎉 Olá, *" . $eventArray['name_client'] . "*!\n";
        $messagem .= "Seu agendamento no KaRAJO foi confirmado com sucesso!\n\n";
        $messagem .= "📅 *Data:* " . date('d/m/Y', strtotime($eventArray['data'])) . "\n";
        $messagem .= "🕒 *Horário:* " . $eventArray['hora'] . "\n";
        // $messagem .= "📍 *Local:* Studio Glam - Rua das Flores, 123 - Centro, São Paulo/SP\n\n";
        $messagem .= "💇‍♀️ *Serviço:* " . $eventArray['service'] . "\n";
        $messagem .= "💰 *Valor:* R$ " . number_format($eventArray['valor_total'], 2, ',', '.') . "\n";
        $messagem .= "📝 *Observações:* " . ($eventArray['observacoes'] ? $eventArray['observacoes'] : "Nenhuma") . "\n\n";
        $messagem .= "Qualquer dúvida, estamos à disposição.\n";
        $messagem .= "Até breve! ✨";
    
        // Dados para envio
        $numero = '55'.$eventArray['phone']; // deve estar no formato internacional, ex: 5591999999999
        // dd($numero);
        $payload = json_encode([
            "number" => $numero,
            "text" => $messagem,
            "delay" => 0
        ]);
    
        // Enviando via cURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost:8080/message/sendText/Vini",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "apikey: 429683C4C977415CAAFCCE10F7D57E11"
            ],
        ]);
    
        $response = curl_exec($curl);
        // dd($response);
        $err = curl_error($curl);
        curl_close($curl);
    
        if ($err) {
            $this->dispatch('alert', [
                'icon' => 'error',
                'title' => 'Erro',
                'text'  => 'Erro ao enviar lembrete: ' . $err,
                'position' => 'center'
            ]);
        } else {
            $this->dispatch('alert', [
                'icon' => 'success',
                'title' => 'Enviado',
                'text'  => 'Lembrete enviado com sucesso!',
                'position' => 'center'
            ]);
        }
    }
    
    public function loadEvents()
    {
    

        $this->events = ModelsSchedules::with(['cliente', 'servicos'])->get()->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'client_id' => $schedule->cliente->id,
                'name_client' => $schedule->cliente->name,
                'phone' => $schedule->cliente->phone,
                'service' =>  $schedule->servicos->pluck('title')->implode(', '),
                'data' => $schedule->data,
                'hora'  => \Carbon\Carbon::parse($schedule->hora)->format('H:i'),
                'observacoes' => $schedule->observacoes,
                'valor_total' => $schedule->valor_total,
            ];
        })->toArray();

        // dd($this->events);
    }
    public function generateCalendar()
    {
        Carbon::setLocale('pt_BR');
    
        $this->days = [];
        $startOfMonth = $this->currentDate->copy()->startOfMonth();
        $endOfMonth = $this->currentDate->copy()->endOfMonth();
    
        // Dias do mês anterior
        $startOfWeek = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        if ($startOfWeek->lt($startOfMonth)) {
            while ($startOfWeek->lt($startOfMonth)) {
                $this->addDayToCalendar($startOfWeek, false);
                $startOfWeek->addDay();
            }
        }
    
        // Dias do mês atual
        $currentDay = $startOfMonth->copy();
        while ($currentDay->lte($endOfMonth)) {
            $this->addDayToCalendar($currentDay, true);
            $currentDay->addDay();
        }
    
        // Dias do próximo mês
        $endOfWeek = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);
        if ($endOfWeek->gt($endOfMonth)) {
            $currentDay = $endOfMonth->copy()->addDay();
            while ($currentDay->lte($endOfWeek)) {
                $this->addDayToCalendar($currentDay, false);
                $currentDay->addDay();
            }
        }
    }
    

    protected function addDayToCalendar(Carbon $date, $isCurrentMonth)
    {
        $formattedDate = $date->format('Y-m-d');

        $dayEvents = array_filter($this->events, function ($event) use ($formattedDate) {
            return $event['data'] === $formattedDate;
        });

        $this->days[] = [
            'data' => $date->copy(),
            'isCurrentMonth' => $isCurrentMonth,
            'isToday' => $date->isToday(),
            'events' => array_values($dayEvents) // array_values para reindexar
        ];
    }

    public function previousMonth()
    {
        $this->currentDate->subMonth();
        $this->generateCalendar();
    }

    public function nextMonth()
    {
        $this->currentDate->addMonth();
        $this->generateCalendar();
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->showDayModal = true;
    }

    public function getSelectedDateEvents()
    {
        return array_filter($this->events, function ($event) {
            return $event['data'] === $this->selectedDate;
        });
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
