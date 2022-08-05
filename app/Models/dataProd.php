<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataProd extends Model
{
    use HasFactory;

    protected $table = 'pma_dailyprod_tc';
    protected $fillable = [
        'tgl',
        'pit',
        'ob',
        'coal',
        'cuaca',
        'kodesite'
    ];
    public $timestamps = false;
}
