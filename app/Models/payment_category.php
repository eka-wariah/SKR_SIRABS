<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class payment_category extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'payment_categories';
    protected $primaryKey = 'pym_id';
    protected $guarded = [];

    const CREATED_AT = 'pym_created_at';
    const UPDATED_AT = 'pym_updated_at';
    const DELETED_AT = 'pym_deleted_at';
}
