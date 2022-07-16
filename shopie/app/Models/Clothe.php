<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clothe extends Model
{
    use HasFactory;

    protected $table = 'clothes';

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'price',
        'quantity',
        'description'
    ];

    /* return $this->hasMany(Avaliability::class); */
/*     public function location() {
        return $this->hasOneThrough(Location::class, Avaliability::class, 'clothe_id', 'id', 'id', 'location_id');
        //                         (C1, C2, vezava_avaliability_clothe,lokalen_locations , lokalen_clothe, lokalen_avaliability)
    }
 */
    public function images() {
        return $this->hasMany(Image::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function avaliabilities() {
        return $this->hasMany(Avaliability::class);
    }

    public function likes() {
        return $this->hasMany(Like::class)->count();
    }
}
