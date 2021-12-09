<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store_collection extends Model
{
    use HasFactory;
    protected $table = 'collection_store';
    protected $primaryKey = 'id';
    protected $fillable =[
        'store_id','user_id'
    ];

}
