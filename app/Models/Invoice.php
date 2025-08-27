<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'inv_id';

    protected $fillable = [
        'household_id',
        'inv_usr_id',
        'payment_category_id',
        'invoice_number',
        'periode',
        'due_date',
        'amount',
        'status',
        'notes',
    ];

    /**
     * Relasi ke User
     */
  
public function user()
{
    return $this->household?->user;
}



    /**
     * Relasi ke PaymentCategory
     */
    public function paymentCategory()
    {
        return $this->belongsTo(payment_category::class, 'payment_category_id', 'pym_id');
    }

    /**
     * Cek apakah invoice sudah dibayar
     */
    public function isPaid()
    {
        return $this->status === 'paid';
    }
    public function household()
{
    return $this->belongsTo(households::class, 'household_id', 'id');
}

    /**
     * Accessor untuk format amount ke Rupiah
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 2, ',', '.');
    }

    // public function owner() // Pemilik KK
    // {
    //     return $this->household->users()->first();
    // }
    public function owner()
{
    return $this->household?->owner;
}
    
    public function treasurer()
    {
        $usrScope = $this->owner()?->usr_scope_id;
    
        return User::role('treasurer') // dari Spatie
               ->where('usr_scope_id', $usrScope)
               ->first();

        if ($treasurer) {
         echo $treasurer->name . ' - RT ' . $treasurer->usr_scope_id;
    }
    }

    public function scopeForTreasurer($query, $treasurerId)
{
    $treasurer = User::findOrFail($treasurerId);
    $rtId = $treasurer->usr_scope_id;

    return $query->whereHas('household.users', function ($q) use ($rtId) {
        $q->where('usr_scope_id', $rtId);
    });
}
}
