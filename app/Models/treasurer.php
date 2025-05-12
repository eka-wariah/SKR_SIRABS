<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class treasurer extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'trs_id';
    protected $fillable = ['trs_name_id', 'trs_area_id'];
    public $timestamps = false;
    protected $dates = ['trs_deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'trs_name_id', 'usr_id');
    }

    public function areaScope()
    {
        return $this->belongsTo(area_scope::class, 'trs_area_id', 'asc_id');
    }
}
