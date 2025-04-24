<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleService extends Model
{
    //

    protected $fillable = [
        'schedule_id',
        'service_id',
    ];

    // public function cliente()
    // {
    //     return $this->belongsTo(Clients::class, 'client_id');
    // }

    // public function servicos()
    // {
    //     return $this->belongsToMany(Services::class, 'services');
    // }
}
