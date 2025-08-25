<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function sizes()
    {
        return $this->hasMany(VariantSize::class, 'variant_id');
    }

    public function images()
    {
        return $this->hasMany(VariantImage::class, 'variant_id');
    }

    public function details()
    {
        return $this->hasMany(VariantDetail::class, 'variant_id');
    }
}
