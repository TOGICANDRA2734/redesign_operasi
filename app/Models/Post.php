<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'pma_dailyprod_posts';


    protected $fillable =['body'];
    
    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->where('created_at', DB::raw('Curdate()'));
    }
}
