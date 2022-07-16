<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliability extends Model
{
    use HasFactory;

    protected $table = 'avaliabilities';

    protected $fillable = [
        'clothe_id',
        'location_id',
        'quantity'
    ];

    public function location() {
        return $this->BelongsTo(Location::class);
    }
}
