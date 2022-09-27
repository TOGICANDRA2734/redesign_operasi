<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant_Pap extends Model
{
    use HasFactory;
    
    protected $fillable = ['nom_unit', 
    'tgl',
    'waktu', 
    'file',   
    'kode_bagian',   
    'kodesite',
    'del'];
    protected $table = 'plant_pap';
    public $timestamps=false;
}