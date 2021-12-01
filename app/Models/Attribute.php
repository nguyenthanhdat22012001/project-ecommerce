<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $table = 'attribute_product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id', 'name','style','hide'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id', 'id');
    }
}
