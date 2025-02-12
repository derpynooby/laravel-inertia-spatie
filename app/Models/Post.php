<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'post',
    ];

    /**
     * The attributes that should be guarded for serialization.
     *
     * @var list<string>
     */
    protected $guarded = [
        'id',
    ];

    // users relationship
    public function user():BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
}
