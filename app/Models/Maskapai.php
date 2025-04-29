<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maskapai extends Model
{
    use HasFactory;
    protected $fillable = ['nama_maskapai', 'kode_maskapai', 'logo_path'];
}
