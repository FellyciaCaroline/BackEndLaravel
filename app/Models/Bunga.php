<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bunga extends Model
{
    protected $fillable = [
        "foto",
        "nama_bunga",
        "deskripsi"
    ];
}
