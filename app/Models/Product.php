<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function scopeFilter($query, \App\Filters\QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function order_item()
    {
         return $this->hasMany(Order_item::class);
    }
}
