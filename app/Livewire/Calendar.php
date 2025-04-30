<?php

namespace App\Livewire;

use App\Models\Clients;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\Schedules as ModelsSchedules;
use Twilio\Rest\Client;

// use Twilio\Rest\Client;



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
        // dd($eventArray);

        $sid = env('TWILIO_SID');
        $numero_com_55 = '+55' . $eventArray['phone'];
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);


        $messagem = "🎉 Olá, **" . $eventArray['name_client'] . "**!\n";
        $messagem .= "Seu agendamento do KaRAJO foi confirmado com sucesso!\n\n";
        $messagem .= "📅 **Data**: " . date('d/m/Y', strtotime($eventArray['data'])) . "\n";
        $messagem .= "🕒 **Horário**: " . $eventArray['hora'] . "\n";
        $messagem .= "📍 **Local**: Studio Glam - Rua das Flores, 123 - Centro, São Paulo/SP\n\n";
        $messagem .= "💇‍♀️ **Serviço**: " . $eventArray['service'] . "\n";
        $messagem .= "💰 **Valor**: R$ " . number_format($eventArray['valor_total'], 2, ',', '.') . "\n";
        $messagem .= "📝 **Observações**: " . ($eventArray['observacoes'] ? $eventArray['observacoes'] : "Nenhuma") . "\n\n";
        $messagem .= "Qualquer dúvida, estamos à disposição.\n";
        $messagem .= "Até breve! ✨";
    

        $message = $twilio->messages
            ->create("whatsapp:" . $numero_com_55, [
                "from" => env('TWILIO_WHATSAPP_FROM'),
                "body" => $messagem
            ]);

        if ($message) {
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
        // Substitua isso por sua lógica de carregamento de eventos
        // // Pode ser do banco de dados ou outra fonte
        // $this->events = [
        //     [
        //         'id' => 1,
        //         'date' => Carbon::now()->format('Y-m-d'),
        //         'time' => '09:00',
        //         'title' => 'Maquiagem Social',
        //         'description' => 'Cliente: Ana Silva - Duração: 1h30',
        //         'type' => 'social',
        //         'status' => 'confirmed'
        //     ],
        //     [
        //         'id' => 1,
        //         'date' => Carbon::now()->format('Y-m-d'),
        //         'time' => '09:00',
        //         'title' => 'Maquiagem Social',
        //         'description' => 'Cliente: Ana Silva - Duração: 1h30',
        //         'type' => 'social',
        //         'status' => 'confirmed'
        //     ],
        //     [
        //         'id' => 1,
        //         'date' => Carbon::now()->format('Y-m-d'),
        //         'time' => '09:00',
        //         'title' => 'Maquiagem Social',
        //         'description' => 'Cliente: Ana Silva - Duração: 1h30',
        //         'type' => 'social',
        //         'status' => 'confirmed'
        //     ],
        //     [
        //         'id' => 1,
        //         'date' => Carbon::now()->format('Y-m-d'),
        //         'time' => '09:00',
        //         'title' => 'Maquiagem Social',
        //         'description' => 'Cliente: Ana Silva - Duração: 1h30',
        //         'type' => 'social',
        //         'status' => 'confirmed'
        //     ],
        //     [
        //         'id' => 2,
        //         'date' => Carbon::now()->format('Y-m-d'),
        //         'time' => '14:00',
        //         'title' => 'Maquiagem Noiva',
        //         'description' => 'Cliente: Maria Oliveira - Pré-wedding',
        //         'type' => 'bridal',
        //         'status' => 'confirmed'
        //     ],
        //     [
        //         'id' => 3,
        //         'date' => Carbon::now()->addDays(1)->format('Y-m-d'),
        //         'time' => '10:30',
        //         'title' => 'Maquiagem Artística',
        //         'description' => 'Cliente: Carla Santos - Evento corporativo',
        //         'type' => 'artistic',
        //         'status' => 'pending'
        //     ],
        //     [
        //         'id' => 4,
        //         'date' => Carbon::now()->addDays(2)->format('Y-m-d'),
        //         'time' => '16:00',
        //         'title' => 'Maquiagem Editorial',
        //         'description' => 'Cliente: Revista Beauty - Sessão fotográfica',
        //         'type' => 'editorial',
        //         'status' => 'confirmed'
        //     ],
        //     [
        //         'id' => 5,
        //         'date' => Carbon::now()->addDays(3)->format('Y-m-d'),
        //         'time' => '11:00',
        //         'title' => 'Aula de Automaquiagem',
        //         'description' => 'Cliente: Grupo de 5 pessoas',
        //         'type' => 'workshop',
        //         'status' => 'confirmed'
        //     ],
        //     [
        //         'id' => 6,
        //         'date' => Carbon::now()->addDays(5)->format('Y-m-d'),
        //         'time' => '13:30',
        //         'title' => 'Maquiagem para Festa',
        //         'description' => 'Cliente: Juliana Costa - Aniversário de 15 anos',
        //         'type' => 'party',
        //         'status' => 'confirmed'
        //     ]
        // ];


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
