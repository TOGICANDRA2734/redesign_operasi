<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower extends Model
{
    use HasFactory;
    protected $table = 'mp_biodata';
    protected $guarded = [];
    public $timestamps = false;
}
