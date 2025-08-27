<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedReport extends Model
{
    use HasFactory;

    protected $table = 'uploaded_reports'; // nama tabel
    protected $fillable = [
        'user_id',
        'file_url',
        'bulan',
        'tahun',
    ];

    // Relasi ke user pengunggah
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
