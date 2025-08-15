<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantSize extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'variant_id',
        'size',
        'stock'
    ];

    public $timestamps = false;

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }
}
