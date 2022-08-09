<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productivity extends Model
{
    use HasFactory;
    protected $table = 'pma_dailyprod_pty';
    protected $fillable = [
        'tgl',
        'nom_unit',
        'type',
        'jam',
        'pty',
        'dist',
        'ket',
        'kodesite',
        'pit',
        'del'
    ];
    public $timestamps = false;
}
