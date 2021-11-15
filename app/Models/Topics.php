<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    use HasFactory;
    protected $table='topics';
    protected $primaryKey='id';
    protected $fillable=[
        'name','slug','description','hide',
    ];
}
