<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant_Populasi extends Model
{
    use HasFactory;
    protected $table='plant_populasi';
    protected $fillable= [
        'nom_unit',
        'model',
        'type_unit',
        'sn',
        'engine_brand',
        'engine_model',
        'engine_sn',
        'HP',
        'DO',
        'pic_1',
        'pic_2',
        'height',
        'width',
        'length',
        'fuel',
        'del',
    ];
    public $timestamps =false;
}
