<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateMessages extends Model
{
    use HasFactory;

    protected $fillable = [
        'sent_id',
        'recieved_id',
        'body'
    ];
}
