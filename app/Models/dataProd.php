<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataProd extends Model
{
    use HasFactory;

    protected $table = 'pma_dailyprod_tc';
    protected $guarded = [];
    public $timestamps = false;
}
