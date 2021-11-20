<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'store';
    protected $primaryKey = 'id';
    protected $fillable =[
        'user_id','cate_id','name','slug','address','img','phone','description','hide'
    ];

}
