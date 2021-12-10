<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionStore extends Model
{
    use HasFactory;
    protected $table = 'collection_store';
    protected $primaryKey = 'id';
    protected $fillable =[
        'store_id','user_id'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }
}
