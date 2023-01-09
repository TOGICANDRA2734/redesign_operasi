<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataPlan extends Model
{
    use HasFactory;

    protected $table = 'pma_dailyprod_plan';
    protected $guarded = [];
    public $timestamps = false;
}
