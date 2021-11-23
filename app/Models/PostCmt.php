<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCmt extends Model
{
    use HasFactory;
    protected $table='comment_post';
    protected $primaryKey='id';
    protected $fillable=[
        'post_id','user_id','comment','parent_id','hide',
    ];
}
