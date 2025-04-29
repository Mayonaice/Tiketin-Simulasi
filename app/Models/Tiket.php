<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $fillable = ['jadwal_id', 'kode_tiket', 'nomor_kursi', 'harga', 'status', 'keterangan'];
    
    public function jadwal() 
    { 
        return $this->belongsTo(\App\Models\JadwalPenerbangan::class, 'jadwal_id'); 
    }
    
    public function transaksi()
    {
        return $this->belongsTo(\App\Models\Transaksi::class);
    }
}
