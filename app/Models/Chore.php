<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chore extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'chore_name',
        'is_operational'
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
