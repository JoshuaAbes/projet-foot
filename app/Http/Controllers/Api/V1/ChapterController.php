<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChapterRequest;
use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ChapterController extends Controller
{
    /**
     * Display a listing of the chapters for a story.
     */
    public function index(Story $story): JsonResponse
    {
        $chapters = $story->chapters()->with('choices')->get();
        
        return response()->json([
            'data' => $chapters
        ]);
    }

    /**
     * Store a newly created chapter.
     */
    public function store(ChapterRequest $request): JsonResponse
    {
        $chapter = Chapter::create($request->validated());
        
        // If this is the first chapter created for the story, set it as the first chapter
        $story = Story::find($request->story_id);
        if (!$story->first_chapter_id) {
            $story->update(['first_chapter_id' => $chapter->id]);
        }
        
        return response()->json([
            'message' => 'Chapter created successfully',
            'data' => $chapter
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified chapter with its choices.
     */
    public function show(Chapter $chapter): JsonResponse
    {
        $chapter->load('choices.nextChapter');
        
        return response()->json([
            'data' => $chapter
        ]);
    }

    /**
     * Update the specified chapter.
     */
    public function update(ChapterRequest $request, Chapter $chapter): JsonResponse
    {
        $chapter->update($request->validated());
        
        return response()->json([
            'message' => 'Chapter updated successfully',
            'data' => $chapter
        ]);
    }

    /**
     * Remove the specified chapter.
     */
    public function destroy(Chapter $chapter): JsonResponse
    {
        // Check if this chapter is the first chapter of any story
        $story = $chapter->storiesStartingHere()->first();
        if ($story) {
            return response()->json([
                'message' => 'Cannot delete chapter as it is the first chapter of a story'
            ], Response::HTTP_CONFLICT);
        }
        
        $chapter->delete();
        
        return response()->json([
            'message' => 'Chapter deleted successfully'
        ]);
    }
}
