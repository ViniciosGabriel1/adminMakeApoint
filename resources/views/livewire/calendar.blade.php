<div class="calendar-container w-full max-w-4xl mx-auto">
    <!-- Cabeçalho aumentado -->
    <div class="calendar-header mb-6">
        <button wire:click="previousMonth" class="calendar-nav-button text-xl p-2">&lt;</button>
        <h2 class="calendar-title text-2xl font-bold">{{ $currentDate->format('F Y') }}</h2>
        <button wire:click="nextMonth" class="calendar-nav-button text-xl p-2">&gt;</button>
    </div>
    
    <!-- Dias da semana com tamanho aumentado -->
    <div class="calendar-weekdays grid grid-cols-7 gap-2 mb-2">
        @foreach(['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $day)
            <div class="calendar-weekday text-lg font-medium text-center py-2">{{ $day }}</div>
        @endforeach
    </div>
    
    <!-- Dias do mês com células maiores -->
    <div class="calendar-days grid grid-cols-7 gap-2">
        @foreach($days as $day)
            <div wire:click="selectDate('{{ $day['date']->format('Y-m-d') }}')"
                 class="calendar-day {{ $day['isCurrentMonth'] ? 'current-month' : 'other-month' }} 
                        {{ $day['isToday'] ? 'today' : '' }}
                        {{ $day['date']->format('Y-m-d') === $selectedDate ? 'selected-day' : '' }}
                        h-32 p-2 relative rounded-lg transition-all duration-200 hover:shadow-md">
                
                <div class="day-number text-lg font-medium">{{ $day['date']->day }}</div>
                
                @if(count($day['events']) > 0)
                    <div class="event-indicator absolute top-2 right-2 bg-rosa text-white rounded-full w-6 h-6 flex items-center justify-center" 
                         title="{{ count($day['events']) }} agendamento(s)">
                        {{ count($day['events']) }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    <!-- Modal ampliado -->
    @if($showDayModal)
        <div class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
             wire:click="$set('showDayModal', false)">
            <div class="modal-content bg-white rounded-lg w-full max-w-md max-h-[80vh] overflow-y-auto" @click.stop>
                <div class="modal-header bg-rosa text-white p-4 rounded-t-lg flex justify-between items-center">
                    <h3 class="text-xl font-bold">Agendamentos em {{ Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}</h3>
                    <button wire:click="$set('showDayModal', false)" class="modal-close text-2xl">&times;</button>
                </div>
                
                <div class="modal-body p-4">
                    @if(count($this->getSelectedDateEvents()) > 0)
                        @foreach($this->getSelectedDateEvents() as $event)
                            <div class="event-item bg-rosa-50 border-l-4 border-rosa p-4 rounded-lg mb-3">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-lg text-rosa-800">{{ $event['title'] }}</h4>
                                        <p class="text-gray-600 mt-1 text-sm">{{ $event['description'] }}</p>
                                        <div class="mt-2 flex items-center text-sm">
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-rosa-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg> --}}
                                            <span class="text-rosa-600">{{ $event['time'] ?? 'Horário não definido' }}</span>
                                        </div>
                                    </div>
                                    <span class="bg-rosa text-white px-3 py-1 rounded-full text-sm">
                                        {{ $event['type'] ?? 'Geral' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2 text-lg">Nenhum agendamento para este dia</p>
                        </div>
                    @endif
                </div>
                
                <div class="modal-footer bg-gray-50 p-4 rounded-b-lg text-right">
                    <button wire:click="$set('showDayModal', false)" 
                            class="modal-button bg-rosa hover:bg-rosa-700 text-white px-4 py-2 rounded transition-colors">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

