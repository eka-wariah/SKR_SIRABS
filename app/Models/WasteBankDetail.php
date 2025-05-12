<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteBankDetaiL extends Model
{
    protected $table = 'waste_bank_details';
    protected $fillable = ['waste_bank_id', 'trc_id', 'berat', 'total'];

    public function trashCategory()
    {
        return $this->belongsTo(trash_category::class, 'trc_id');
    }

    public function wasteBank()
    {
        return $this->belongsTo(waste_bank::class);
    }
}
