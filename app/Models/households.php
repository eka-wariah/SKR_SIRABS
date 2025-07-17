<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class households extends Model
{
    protected $fillable = [
        'no_kk',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function payments()
    {
        return $this->hasMany(payments::class);
    }
}
