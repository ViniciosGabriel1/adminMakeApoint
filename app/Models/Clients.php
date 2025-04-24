<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    //

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone'
    ];


    public function schedules()
    {
        return $this->hasMany(Schedules::class);
    }
}
