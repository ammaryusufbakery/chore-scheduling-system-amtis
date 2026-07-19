<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    //use SoftDeletes;

    protected $fillable = [
        'schedule_date',
        'day',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
