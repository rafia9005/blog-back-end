<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Posts extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'content',
        'author'
    ];

    public function Author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
