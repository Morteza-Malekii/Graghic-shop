<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //public $fillable = ['title','slug'];
    public $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
