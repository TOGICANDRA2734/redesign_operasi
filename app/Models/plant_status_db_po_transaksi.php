<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plant_status_db_po_transaksi extends Model
{
    use HasFactory;
    protected $table='plant_status_db_po_transaksi';
    protected $fillable= [
        'no_po',
        'id_tiket_po',
        'po_date',
        'supplier',
        'item',
        'no_mrs',
        'mrs_date',
        'del',
    ];
    public $timestamps =false;
}
