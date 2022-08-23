<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PO extends Model
{
    use HasFactory;
    protected $table='plant_status_db_po';
    protected $fillable= [
        'id_tiket_po',
        'dok_po',
        'no_po',
        'tgl_po',
        'dealer_po',
        'del',
    ];
    public $timestamps =false;
}
