<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PekerjaanLahan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan_lahan';

    protected $fillable = [
        'lahan_id',
        'users_id'
    ];
    
    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function lahan(){
        return $this->belongsTo(Lahan::class);
    }
}
