<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryFiles extends Model
{
    use HasFactory;

    protected $fillable = ['folder', 'filename', 'del'];
    public $timestamps = false;
    protected $table = "pma_dailyprod_tmp_files";
}
