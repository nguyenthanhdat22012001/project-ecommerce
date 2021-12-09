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
        'order_id','product_id','amount','price','product_name'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id', 'id');
    }
}
