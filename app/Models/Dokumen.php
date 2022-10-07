<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    
    protected $fillable = ['no_gr', 'tgl_gr', 'tgl_terima', 'subject_gr', 'qty', 'unit_gr', 'keterangan', 'status', 'nama_ttd1', 'nama_ttd2', 'nama_ttd3', 'nama_ttd4', 'nama_ttd5', 'nama_ttd6', 'chk_ttd1', 'chk_ttd2', 'chk_ttd3', 'chk_ttd4','chk_ttd5', 'chk_ttd6', 'alasan_batal', 'tgl_batal','tgl_selesai', 'kodesite'];
    protected $table = 'dokumen_gr';
    public $timestamps=false;
}
