<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = ['chapter_id', 'next_chapter_id', 'text'];

    /**
     * Get the chapter that owns this choice.
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Get the next chapter that this choice leads to.
     */
    public function nextChapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'next_chapter_id');
    }
}