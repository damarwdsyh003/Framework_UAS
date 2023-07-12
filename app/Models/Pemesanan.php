<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected $table="pemesanan";
    protected $primaryKey="id_pemesanan";
    protected $fillable=[
        'tgl_pemesanan',
        'id_tenant',
        'id_users',
    ];

    public function tenant()
    {
        return $this->belongsto('App\Models\Tenant', 'id_tenant', 'id_tenant');
    }

    public function minuman()
    {
        return $this->belongsto('App\Models\Users', 'id_users', 'id_users');
    }
}
