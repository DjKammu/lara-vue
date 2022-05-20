<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   use HasFactory;

    protected $perPage = 9;

    protected $fillable = [
     'name' , 'description' ,'author_id'
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
