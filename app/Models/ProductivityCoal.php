<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductivityCoal extends Model
{
    use HasFactory;
    protected $table = 'pma_dailyprod_pty_coal';
    protected $fillable = [
        'tgl',
        'jam',
        'rit',
        'ket',
        'kodesite',
        'pit',
        'admin',
        'time_admin',
        'del'
    ];
    public $timestamps = false;
}
