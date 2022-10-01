<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantOvh extends Model
{
    use HasFactory;

    protected $table='plant_ovh';
    protected $fillable= [
        'id',
        'nom_unit',
        'model',
        'komponen',
        'ovh_start',
        'ovh_finish',
        'hm',
        'remark',
        'del',
    ];
    public $timestamps =false;
}
