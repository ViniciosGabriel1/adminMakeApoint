<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsappInstance extends Model
{
    use HasFactory;

        protected $table = 'whatsapp_instance';

    protected $fillable = [
        'user_id',
        'instance_name',
        'number',
        'status',
        'status_reason',
        'sender',
        'last_event',
        'last_event_at',
    ];

    protected $casts = [
        'last_event' => 'array',
        'last_event_at' => 'datetime',
    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
