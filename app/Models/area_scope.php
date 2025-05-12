<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class area_scope extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'area_scopes';
    protected $primaryKey = 'asc_id';
    protected $guarded = [];

    const CREATED_AT = 'asc_created_at';
    const UPDATED_AT = 'asc_updated_at';
    const DELETED_AT = 'asc_deleted_at';
}
