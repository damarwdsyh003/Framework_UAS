<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected $table="makanan";
    protected $primaryKey="id_makanan";
    protected $fillable=[
        'nama_makanan',
        'harga_makanan',
    ];
}
