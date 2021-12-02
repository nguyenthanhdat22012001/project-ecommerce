<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table='posts';
    protected $primaryKey='id';
    protected $fillable=[
      'user_id','name','slug','description','hide','thumbs_up'
    ];

    public function comments()
    {
        return $this->hasMany(PostCmt::class,'post_id','id');
    }
}
