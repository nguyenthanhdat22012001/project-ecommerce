<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable =[
        'store_id','cate_id','brand_id','name','slug','img','listimg','description','shortdescription','quantity','price','hide','sort',
    ];
    
}
