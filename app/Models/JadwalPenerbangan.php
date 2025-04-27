<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPenerbangan extends Model
{
    protected $fillable = [
        'maskapai_id', 'kota_asal_id', 'kota_tujuan_id', 'tanggal_berangkat', 'jam_berangkat', 'jam_tiba', 'harga_tiket', 'kapasitas_kursi', 'sisa_kursi'
    ];

    public function maskapai() { return $this->belongsTo(Maskapai::class); }
    public function kotaAsal() { return $this->belongsTo(Kota::class, 'kota_asal_id'); }
    public function kotaTujuan() { return $this->belongsTo(Kota::class, 'kota_tujuan_id'); }
}
