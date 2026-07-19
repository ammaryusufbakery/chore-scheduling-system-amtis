<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'junior_id',
        'chore_id',
        'schedule_id',
        'week',
    ];

    public function junior()
    {
        return $this->belongsTo(Junior::class);
    }

    public function chore()
    {
        return $this->belongsTo(Chore::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
