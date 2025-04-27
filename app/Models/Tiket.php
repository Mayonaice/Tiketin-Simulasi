<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $fillable = ['jadwal_id', 'kode_tiket', 'status'];
    public function jadwal() { return $this->belongsTo(\App\Models\JadwalPenerbangan::class, 'jadwal_id'); }
}
