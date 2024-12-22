<?php

namespace App\Http\Controllers;

use App\Services\IdeaService;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Resources\IdeaResource;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Ideas API Documentation",
 *     description="Ideas API endpoints documentation"
 * )
 */

/**
 * @OA\Schema(
 *     schema="IdeaResource",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="image", type="string", nullable=true),
 *     @OA\Property(property="likes_count", type="integer"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class IdeaController extends Controller
{
    protected $ideaService;

    public function __construct(IdeaService $ideaService)
    {
        $this->ideaService = $ideaService;
    }

    /**
     * @OA\Get(
     *     path="/api/ideas",
     *     summary="Get all ideas",
     *     tags={"Ideas"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of ideas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/IdeaResource")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $ideas = $this->ideaService->getAllIdeas();
        
        if (request()->wantsJson()) {
            return IdeaResource::collection($ideas);
        }
        
        return view('ideas.index', compact('ideas'));
    }

    /**
     * @OA\Post(
     *     path="/api/ideas",
     *     summary="Create a new idea",
     *     tags={"Ideas"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"content"},
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="image", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Idea created successfully"
     *     )
     * )
     */
    public function store(StoreIdeaRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        
        $idea = $this->ideaService->createIdea($validated);
        
        if ($request->wantsJson()) {
            return new IdeaResource($idea);
        }
        
        return redirect()->route('ideas.index')
            ->with('success', 'Fikir başarıyla oluşturuldu!');
    }

    /**
     * @OA\Put(
     *     path="/api/ideas/{id}",
     *     summary="Update an idea",
     *     tags={"Ideas"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Idea updated successfully"
     *     )
     * )
     */
    public function update(StoreIdeaRequest $request, $id)
    {
        $validated = $request->validated();
        $idea = $this->ideaService->updateIdea($id, $validated);
        
        if ($request->wantsJson()) {
            return new IdeaResource($idea);
        }
        
        return redirect()->route('ideas.index')
            ->with('success', 'Fikir başarıyla güncellendi!');
    }

    /**
     * @OA\Delete(
     *     path="/api/ideas/{id}",
     *     summary="Delete an idea",
     *     tags={"Ideas"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Idea deleted successfully"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->ideaService->deleteIdea($id);
        
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Fikir başarıyla silindi!']);
        }
        
        return redirect()->route('ideas.index')
            ->with('success', 'Fikir başarıyla silindi!');
    }
}
