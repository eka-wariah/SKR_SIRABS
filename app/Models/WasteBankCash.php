<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WasteBankCash extends Model
{
    use SoftDeletes;

    protected $table = 'wastebank_cashes';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $dates = ['created_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'usr_id');
    }
    public static function getSaldoTersedia()
{
    return self::sum(\DB::raw("CASE WHEN type = 'Masuk' THEN amount ELSE -amount END"));
}

}
