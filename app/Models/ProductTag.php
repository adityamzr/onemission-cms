<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductTag extends Pivot
{
    protected $table = 'product_tags';
    protected $fillable = [
        'product_id',
        'tag_id',
    ];
    public $timestamps = true;
}
