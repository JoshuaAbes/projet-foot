<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChoiceRequest;
use App\Models\Chapter;
use App\Models\Choice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the choices for a chapter.
     */
    public function index(Chapter $chapter): JsonResponse
    {
        $choices = $chapter->choices()->with('nextChapter')->get();
        
        return response()->json([
            'data' => $choices
        ]);
    }

    /**
     * Store a newly created choice.
     */
    public function store(ChoiceRequest $request): JsonResponse
    {
        $choice = Choice::create($request->validated());
        
        return response()->json([
            'message' => 'Choice created successfully',
            'data' => $choice
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified choice.
     */
    public function update(ChoiceRequest $request, Choice $choice): JsonResponse
    {
        $choice->update($request->validated());
        
        return response()->json([
            'message' => 'Choice updated successfully',
            'data' => $choice
        ]);
    }

    /**
     * Remove the specified choice.
     */
    public function destroy(Choice $choice): JsonResponse
    {
        $choice->delete();
        
        return response()->json([
            'message' => 'Choice deleted successfully'
        ]);
    }
}
