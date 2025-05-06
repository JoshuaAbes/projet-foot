<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryRequest;
use App\Models\Story;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StoryController extends Controller
{
    /**
     * Display a listing of the stories.
     */
    public function index(): JsonResponse
    {
        $stories = Story::with('firstChapter')->get();
        
        return response()->json([
            'data' => $stories
        ]);
    }

    /**
     * Store a newly created story.
     */
    public function store(StoryRequest $request): JsonResponse
    {
        $story = Story::create($request->validated());
        
        return response()->json([
            'message' => 'Story created successfully',
            'data' => $story
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified story with its first chapter.
     */
    public function show(Story $story): JsonResponse
    {
        $story->load('firstChapter');
        
        return response()->json([
            'data' => $story
        ]);
    }

    /**
     * Update the specified story.
     */
    public function update(StoryRequest $request, Story $story): JsonResponse
    {
        $story->update($request->validated());
        
        return response()->json([
            'message' => 'Story updated successfully',
            'data' => $story
        ]);
    }

    /**
     * Remove the specified story.
     */
    public function destroy(Story $story): JsonResponse
    {
        $story->delete();
        
        return response()->json([
            'message' => 'Story deleted successfully'
        ]);
    }
}
