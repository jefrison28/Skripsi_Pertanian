<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressPekerjaanLahan extends Model
{
    use HasFactory;
    protected $table = 'progress_pekerjaan_lahan';

    protected $fillable = [
        'lahan_id',
        'deskripsi',
        'tanggal_selesai',
        'status'
    ];

    public function lahan(){
        return $this->belongsTo(Lahan::class);
    }
}
