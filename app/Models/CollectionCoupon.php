<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionCoupon extends Model
{
    use HasFactory;
    protected $table = 'collection_coupons';
    protected $primaryKey = 'id';
    protected $fillable =[
        'coupon_id','user_id'
    ];
    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'coupon_id','id');
    }
}
