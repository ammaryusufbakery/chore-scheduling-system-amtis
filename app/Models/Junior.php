<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Junior extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
