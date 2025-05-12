<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class waste_bank extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'waste_banks';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = ['wtb_name_id', 'wtb_total_money'];

    public function user()
    {
        return $this->belongsTo(User::class, 'wtb_name_id', 'usr_id');
    }

    public function details()
    {
        return $this->hasMany(WasteBankDetail::class, 'waste_bank_id');
    }
}
