<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'first_chapter_id'];

    /**
     * Get the first chapter of the story.
     */
    public function firstChapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'first_chapter_id');
    }

    /**
     * Get all chapters in this story.
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

    /**
     * Get all choices in this story through its chapters.
     */
    public function choices(): HasManyThrough
    {
        return $this->hasManyThrough(Choice::class, Chapter::class);
    }

    /**
     * Get all progressions for this story.
     */
    public function progressions(): HasMany
    {
        return $this->hasMany(StoryProgression::class);
    }
}
