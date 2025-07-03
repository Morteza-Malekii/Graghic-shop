<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    public $guarded =[];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
