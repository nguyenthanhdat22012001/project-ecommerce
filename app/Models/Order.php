<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable =[
        'coupon_sku','coupon_price','store_id','parent_id','payment_id','user_id','name','address','phone','note','status','shippingprice','totalprice','totalQuantity'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class,'parent_id', 'id');
    }
    public function sub_order()
    {
        return $this->hasMany(Order::class,'parent_id','id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id','id');
    }
}
