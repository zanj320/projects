<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = 'id_comment';

    protected $fillable = [
        'id_user',
        'data'
    ];

    public function user() : BelongsTo {
        return $this->BelongsTo(User::class, 'id_user', 'id_user');
    }
}
