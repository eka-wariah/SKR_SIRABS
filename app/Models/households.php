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
        return $this->hasMany(User::class, 'household_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(payments::class);
    }
    
    public function waterRegistration()
    {
    return $this->hasOne(registration_water::class, 'rgw_household_id', 'id')->where('rgw_status', 'Aktif');
    }
    public function owner()
{
    return $this->hasOne(User::class, 'household_id', 'id')->oldest();
}
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'household_id', 'id');
    }
}
