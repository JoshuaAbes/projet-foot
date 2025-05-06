<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoryProgressionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // On gérera l'autorisation via middleware
    }

    public function rules(): array
    {
        return [
            'story_id' => 'required|exists:stories,id',
            'current_chapter_id' => 'required|exists:chapters,id'
        ];
    }
}
