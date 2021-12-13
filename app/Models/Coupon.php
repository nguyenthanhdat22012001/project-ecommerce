<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupon';
    protected $primaryKey = 'id';
    protected $fillable =[
        'store_id','sku','name','price','date_begin','date_end','hide','condition',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id', 'id');
    }
}
