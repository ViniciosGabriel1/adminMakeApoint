<?php

namespace App\Livewire;

use App\Models\Schedules;
use App\Models\Clients;
use App\Models\Services;
use Livewire\Component;

class Homebox extends Component
{


    
    public function render()
    {

        return view('livewire.homebox', [
            'clientes' => Clients::where('user_id',auth()->id())->count(),
            'servicos' => Services::where('user_id',auth()->id())->count(),
            'valorTotal' => schedules::where('status','confirmed')->sum('valor_total'),
            'schedules' => Schedules::all()->count(),
        ]);
    }
}
