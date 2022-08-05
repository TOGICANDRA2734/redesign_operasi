<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendala extends Model
{
    use HasFactory;
    protected $table = 'pma_dailyprod_kendala';
    protected $fillable = [
        'tgl',
        'unit',
        'shift',
        'awal',
        'akhir',
        'ket',
        'kodesite'
    ];
    public $timestamps = false;
}
