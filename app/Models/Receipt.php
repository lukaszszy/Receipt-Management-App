<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = ['id', 'payment_date', 'payment_amount', 'user_id', 'store_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function receipt_items()
    {
        return $this->hasMany('App\Models\ReceiptItem');
    }
}
