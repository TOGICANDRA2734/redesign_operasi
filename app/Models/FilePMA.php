<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilePMA extends Model
{
    use HasFactory;

    protected $fillable = ['tgl', 'waktu', 'file', 'sv', 'tgl_verifikasi', 'kodesite'];
    protected $table = 'pma_transfer_file';
    public $timestamps=false;
}
