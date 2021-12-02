<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThumbsUpPost extends Model
{
    use HasFactory;
    protected $table = 'thumbs_up_posts';
    protected $primaryKey = 'id';
    protected $fillable =['user_id','post_id'];
}
