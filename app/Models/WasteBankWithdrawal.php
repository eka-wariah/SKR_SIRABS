<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteBankWithdrawal extends Model
{
    protected $fillable = ['usr_id', 'amount', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class, 'usr_id', 'usr_id');
    }
    public static function getSaldoTersedia()
    {
        return self::sum(\DB::raw("CASE WHEN type = 'Masuk' THEN amount ELSE -amount END"));
    }
}
