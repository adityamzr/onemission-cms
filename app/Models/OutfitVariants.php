<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutfitVariants extends Model
{
    protected $table = 'outfit_variants';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function outfit()
    {
        return $this->belongsTo(Outfit::class, 'outfit_id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }
}
