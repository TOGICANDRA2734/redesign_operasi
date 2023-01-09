<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataProdex extends Model
{
    use HasFactory;

    protected $table = 'pma_dailyprod_tc_backup_';
    protected $guarded = [];
    public $timestamps = false;
}
