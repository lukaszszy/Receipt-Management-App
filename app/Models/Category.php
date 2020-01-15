<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function receipt_items()
    {
        return $this->belongsTo('App\Models\ReceiptItem');
    }

    public function services()
    {
        return $this->belongsToMany('App\Models\Service', 'categories_services', 'category_id', 'service_id')->withTimestamps();;
    }

    protected $hidden = [
        'pivot'
    ];
}
