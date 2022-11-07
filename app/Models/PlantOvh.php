<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantOvh extends Model
{
    use HasFactory;

    protected $table='plant_ovh';
    protected $guarded = [];
    public $timestamps =false;
}
