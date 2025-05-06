<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryProgression extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'story_id', 'current_chapter_id'];

    /**
     * Get the user that owns the progression.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the story that this progression is for.
     */
    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    /**
     * Get the current chapter for this progression.
     */
    public function currentChapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'current_chapter_id');
    }
}