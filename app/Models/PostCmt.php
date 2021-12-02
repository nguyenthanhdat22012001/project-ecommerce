<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PostCmt extends Model
{
    use HasFactory;
    protected $table='comment_post';
    protected $primaryKey='id';
    protected $fillable=[
        'post_id','user_id','comment','parent_id','hide',
    ];

    public function sub_comments()
    {
        return $this->hasMany(PostCmt::class,'parent_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
