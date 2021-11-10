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
        'user_id','product_id','point','comment','hide',
    ];
}
