<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class payments extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'payments';
    protected $primaryKey = 'pyn_id';
    protected $guarded = [];

    const CREATED_AT = 'pyn_created_at';
    const UPDATED_AT = 'pyn_updated_at';
    const DELETED_AT = 'pyn_deleted_at';

    public function paymentCategory()
{
    return $this->belongsTo(payment_category::class, 'pyn_payment_category_id', 'pym_id');
}
public function user()
{
    return $this->belongsTo(User::class, 'pyn_user_id', 'usr_id');
}

public function treasurer()
{
    return $this->belongsTo(User::class, 'pyn_treasurer_id', 'usr_id');
}

}
