<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['story_id', 'title', 'content', 'is_end'];

    /**
     * Get the story that owns the chapter.
     */
    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    /**
     * Get the choices available from this chapter.
     */
    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }

    /**
     * Stories that start with this chapter.
     */
    public function storiesStartingHere(): HasMany
    {
        return $this->hasMany(Story::class, 'first_chapter_id');
    }
}