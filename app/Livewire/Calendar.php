<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

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
    
    public function loadEvents()
    {
        // Substitua isso por sua lógica de carregamento de eventos
        // Pode ser do banco de dados ou outra fonte
        $this->events = [
            [
                'id' => 1,
                'date' => Carbon::now()->format('Y-m-d'),
                'time' => '09:00',
                'title' => 'Maquiagem Social',
                'description' => 'Cliente: Ana Silva - Duração: 1h30',
                'type' => 'social',
                'status' => 'confirmed'
            ],
            [
                'id' => 2,
                'date' => Carbon::now()->format('Y-m-d'),
                'time' => '14:00',
                'title' => 'Maquiagem Noiva',
                'description' => 'Cliente: Maria Oliveira - Pré-wedding',
                'type' => 'bridal',
                'status' => 'confirmed'
            ],
            [
                'id' => 3,
                'date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'time' => '10:30',
                'title' => 'Maquiagem Artística',
                'description' => 'Cliente: Carla Santos - Evento corporativo',
                'type' => 'artistic',
                'status' => 'pending'
            ],
            [
                'id' => 4,
                'date' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'time' => '16:00',
                'title' => 'Maquiagem Editorial',
                'description' => 'Cliente: Revista Beauty - Sessão fotográfica',
                'type' => 'editorial',
                'status' => 'confirmed'
            ],
            [
                'id' => 5,
                'date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'time' => '11:00',
                'title' => 'Aula de Automaquiagem',
                'description' => 'Cliente: Grupo de 5 pessoas',
                'type' => 'workshop',
                'status' => 'confirmed'
            ],
            [
                'id' => 6,
                'date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'time' => '13:30',
                'title' => 'Maquiagem para Festa',
                'description' => 'Cliente: Juliana Costa - Aniversário de 15 anos',
                'type' => 'party',
                'status' => 'confirmed'
            ]
        ];
    }
    
    public function generateCalendar()
    {
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
        
        $dayEvents = array_filter($this->events, function($event) use ($formattedDate) {
            return $event['date'] === $formattedDate;
        });
        
        $this->days[] = [
            'date' => $date->copy(),
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
        return array_filter($this->events, function($event) {
            return $event['date'] === $this->selectedDate;
        });
    }
    
    public function render()
    {
        return view('livewire.calendar');
    }
}