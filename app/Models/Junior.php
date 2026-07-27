<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Junior extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'start_date',
        'end_date',
        'preferences',
        'status',
    ];

    protected function casts()
    {
        return [
            'preferences' => 'array',
        ];
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
