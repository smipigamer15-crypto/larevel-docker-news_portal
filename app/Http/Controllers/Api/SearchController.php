<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/search",
     *     summary="Search news articles",
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         example="news"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Search results retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = $request->get('q');
        if (!$query) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $results = News::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->latest()
            ->paginate(15);

        return response()->json(['success' => true, 'data' => $results]);
    }

    /**
     * @OA\Get(
     *     path="/search/live",
     *     summary="Live search (autocomplete)",
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         example="news"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Autocomplete results retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string")
     *             ))
     *         )
     *     )
     * )
     */
    public function live(Request $request)
    {
        $query = $request->get('q');
        if (!$query || strlen($query) < 2) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $results = News::where('title', 'LIKE', "%{$query}%")
            ->take(10)
            ->get(['id', 'title']);

        return response()->json(['success' => true, 'data' => $results]);
    }
}