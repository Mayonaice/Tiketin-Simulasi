<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id', 
        'tiket_id', 
        'quantity',
        'total_price',
        'status_bayar',
        'metode_bayar',
        'bukti_bayar'
    ];
    
    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the tiket for this transaction.
     */
    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    } 
}
