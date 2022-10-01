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
        'generator_brand',
        'generator_model',
        'generator_sn',
        'pump_merk',
        'pump_model',
        'pump_sn',
        'comp_merk',
        'comp_model',
        'comp_sn',
        'kapasitas',
        'HP',
        'DO',
        'pic_1',
        'pic_2',
        'height',
        'width',
        'length',
        'fuel',
        'status_bagian',
        'status_kepemilikan',
        'kodesite',
        'del',
    ];
    public $timestamps =false;
}
