<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected $table="tenant";
    protected $primaryKey="id_tenant";
    protected $fillable=[
        'nama_tenant',
        'id_makanan',
        'id_minuman',
    ];

    public function makanan()
    {
        return $this->belongsto('App\Models\Makanan', 'id_makanan', 'id_makanan');
    }

    public function minuman()
    {
        return $this->belongsto('App\Models\Minuman', 'id_minuman', 'id_minuman');
    }
}
