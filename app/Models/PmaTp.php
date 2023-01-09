<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmaTp extends Model
{
    use HasFactory;

    protected $table='pma_tp_testing';
    protected $guarded = [];
    public $timestamps =false;
}
