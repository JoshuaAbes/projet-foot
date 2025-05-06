<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // On gérera l'autorisation via middleware
    }

    public function rules(): array
    {
        return [
            'chapter_id' => 'required|exists:chapters,id',
            'next_chapter_id' => 'required|exists:chapters,id',
            'text' => 'required|string|max:255'
        ];
    }
}
