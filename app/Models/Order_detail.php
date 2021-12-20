<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    protected $primaryKey = 'id';
    protected $fillable =[
        'order_id','product_id','amount','order_id','product_price','product_name','product_img','product_slug','attribute_name'
    ];
    public function product()
    {
        return $this->hasMany(Product::class,'product_id', 'id');
    }
}
