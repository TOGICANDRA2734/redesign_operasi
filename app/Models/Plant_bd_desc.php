<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant_bd_desc extends Model
{
    use HasFactory;
    protected $table='plant_status_bd_desc';
    protected $fillable= [
        'id_tiket',
        'uraian_bd',
    ];
    public $timestamps =false;
}
