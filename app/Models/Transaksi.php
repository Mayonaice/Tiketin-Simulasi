<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id', 
        'tiket_id', 
        'status_bayar',
        'metode_bayar',
        'bukti_bayar'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    } 
}
