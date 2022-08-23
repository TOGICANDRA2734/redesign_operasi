<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant_bd extends Model
{
    use HasFactory;
    protected $table='plant_status_bd';
    protected $fillable= [
        'nom_unit',
        'tgl_bd',
        'tgl_rfu',
        'ket_tgl_rfu',
        'kode_bd',
        'pic',
        'hm',
        'kodesite',
        'keterangan',
        'status_bd',
        'del',
    ];
    public $timestamps =false;
}
