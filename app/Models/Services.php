<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'value',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedules::class, 'schedule_service');
    }
}
