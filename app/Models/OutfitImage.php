<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutfitImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function outfit()
    {
        return $this->belongsTo(Outfit::class, 'outfit_id');
    }
}
