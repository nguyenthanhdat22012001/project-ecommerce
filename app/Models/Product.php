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
    public function attributes()
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
    public function order()
    {
        return $this->hasMany(Order_detail::class,'product_id', 'id');
    }
    public function rating(){
        return $this->hasMany(CmtRating::class,'product_id', 'id')->where('parent_id',null);
    }
}
