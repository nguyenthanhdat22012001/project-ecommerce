<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmtRating extends Model
{
    use HasFactory;
    protected $table='comment_rating';
    protected $primaryKey='id';
    protected $fillable=[
        'user_id','product_id','point','comment','parent_id','hide',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id', 'id');
    }
    public function product(){
    return $this->belongsTo(Product::class,'product_id', 'id');
    }
}
