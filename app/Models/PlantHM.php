<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantHM extends Model
{
    use HasFactory;
    
    
    protected $guarded = [];
    protected $table = 'plant_hm';
    public $timestamps=false;
}
