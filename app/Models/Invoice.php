<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $table = 'pma_invoice';
    protected $guarded = [];
}
