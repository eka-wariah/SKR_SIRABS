<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class registration_water extends Model
{
    protected $table = 'registration_waters';
    protected $primaryKey = 'rgw_id';

    protected $fillable = [
        'rgw_household_id',
        'rgw_applicant_id',
        'rgw_registration_date',
        'rgw_status',
        'rgw_notes',
        'address',
        'rgw_house_photo',
        'rgw_verified_by',
        'rgw_verified_at',
    ];

    public function household()
    {
        return $this->belongsTo(households::class, 'rgw_household_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'rgw_verified_by', 'usr_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'rgw_applicant_id', 'usr_id');
    }
    

}
