<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapBagian extends Model
{
    use HasFactory;
    public $table = 'plant_pap_bagian';
    public $timestamps = false;
    protected $guarded = [];
}
