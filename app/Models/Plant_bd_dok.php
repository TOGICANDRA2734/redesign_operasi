<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant_bd_dok extends Model
{
    use HasFactory;
    protected $table='plant_status_bd_dok';
    protected $fillable= [
        'id_tiket',
        'dok_type',
        'dok_no',
        'dok_tgl',
        'uraian',
        'uraian_bd',
        'keterangan',
        'del',
    ];
    public $timestamps =false;
}
