<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kota extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kota', 'kode_bandara'];
}
