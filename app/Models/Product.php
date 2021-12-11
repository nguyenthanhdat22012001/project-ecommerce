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
        'store_id','cate_id','brand_id','name','slug','img','listimg','description','shortdescription','hide','sort','price','discount'
    ];
    public function attribute()
    {
        return $this->hasMany(Attribute::class,'product_id', 'id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id', 'id');
    }
    public function cate()
    {
        return $this->belongsTo(Category::class,'brand_id', 'id');
    }
    public function store()
    {
        return $this->hasOne(Store::class,'id','store_id');
    }
}
