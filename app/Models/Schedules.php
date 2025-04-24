<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    protected $fillable = [
        'client_id',
        'data',
        'hora',
        'observacoes',
        'valor_total'
    ];

    public function cliente()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function servicos()
    {
        return $this->belongsToMany(Services::class, 'schedule_service', 'schedule_id', 'service_id');
    }
}
