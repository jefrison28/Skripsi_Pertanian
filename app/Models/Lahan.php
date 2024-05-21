<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    use HasFactory;
    protected $table = 'lahan';

    protected $fillable = [
        'namalahan',
        'alamat_lahan',
        'luas_lahan',
        'users_id',
        'latitude',
        'longitude',
        'pekerjaan_selesai',
        'status'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function pekerjaanlahan(){
        return $this->hasMany(PekerjaanLahan::class);
    }

    public function progresspekerjaanlahan(){
        return $this->hasMany(ProgressPekerjaanLahan::class);
    }
}
