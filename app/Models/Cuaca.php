<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuaca extends Model
{
    use HasFactory;
    
    protected $fillable = ['cuaca', 'kodesite', 'tgl', 'jam', 'del'];
    protected $table = 'pma_dailyprod_cuaca';
    public $timestamps=false;
}
