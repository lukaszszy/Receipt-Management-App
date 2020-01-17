<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptItem extends Model
{
    protected $table = 'receipt_items';
    protected $fillable = ['id', 'name', 'price', 'quantity' , 'receipt_id', 'category_id', 'created_at', 'updated_at'];
    protected $hidden = ['category_id'];

    public function receipts()
    {
        return $this->belongsTo('App\Models\Receipt');
    }

    public function categories()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}
