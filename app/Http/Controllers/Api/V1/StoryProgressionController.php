<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryProgressionRequest;
use App\Models\StoryProgression;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StoryProgressionController extends Controller
{
    /**
     * Display a listing of the progressions for the current user.
     */
    public function index(): JsonResponse
    {
        $progressions = StoryProgression::where('user_id', auth()->id())
            ->with(['story', 'currentChapter'])
            ->get();
        
        return response()->json([
            'data' => $progressions
        ]);
    }

    /**
     * Store a newly created progression or update if exists.
     */
    public function store(StoryProgressionRequest $request): JsonResponse
    {
        // Check if progression already exists
        $progression = StoryProgression::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'story_id' => $request->story_id
            ],
            [
                'current_chapter_id' => $request->current_chapter_id
            ]
        );
        
        return response()->json([
            'message' => 'Progression saved successfully',
            'data' => $progression
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified progression.
     */
    public function update(StoryProgressionRequest $request, StoryProgression $progression): JsonResponse
    {
        // Ensure the progression belongs to the authenticated user
        if ($progression->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_FORBIDDEN);
        }
        
        $progression->update([
            'current_chapter_id' => $request->current_chapter_id
        ]);
        
        return response()->json([
            'message' => 'Progression updated successfully',
            'data' => $progression
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
