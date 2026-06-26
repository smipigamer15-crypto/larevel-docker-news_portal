<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="News API",
 *     version="1.0.0",
 *     description="API for managing news articles"
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8082/api",
 *     description="Local server"
 * )
 * 
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 */
class NewsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/news",
     *     summary="Get all news articles",
     *     @OA\Response(
     *         response=200,
     *         description="List of news articles",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $news = News::withCount('comments')->latest()->paginate(15);
        return response()->json(['success' => true, 'data' => $news]);
    }

    /**
     * @OA\Get(
     *     path="/news/{id}",
     *     summary="Get a single news article",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News article details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News article not found"
     *     )
     * )
     */
    public function show($id)
    {
        $news = News::find($id);
        if (!$news) {
            return response()->json(['success' => false, 'message' => 'News article not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $news]);
    }

    /**
     * @OA\Get(
     *     path="/news/category/{category}",
     *     summary="Get news articles by category",
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", enum={"Politics","World","Sports","Culture","Technology","Economy"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of news articles by category",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function byCategory($category)
    {
        $news = News::where('category', $category)->latest()->paginate(15);
        return response()->json(['success' => true, 'data' => $news]);
    }

    /**
     * @OA\Get(
     *     path="/news/{newsId}/comments",
     *     summary="Get comments for a news article",
     *     @OA\Parameter(
     *         name="newsId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of comments",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News article not found"
     *     )
     * )
     */
    public function comments($newsId)
    {
        $news = News::find($newsId);
        if (!$news) {
            return response()->json(['success' => false, 'message' => 'News article not found'], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $news->comments()->with('user')->latest()->get()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/news",
     *     summary="Create a new news article",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","content","category"},
     *             @OA\Property(property="title", type="string", example="Breaking News"),
     *             @OA\Property(property="content", type="string", example="Detailed news content here..."),
     *             @OA\Property(property="category", type="string", example="Politics"),
     *             @OA\Property(property="image", type="string", format="binary", example="image.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="News article created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="News article created"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->only(['title', 'content', 'category']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news = News::create($data);
        return response()->json([
            'success' => true,
            'message' => 'News article created successfully',
            'data' => $news
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/news/{id}",
     *     summary="Update a news article",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated News Title"),
     *             @OA\Property(property="content", type="string", example="Updated content here..."),
     *             @OA\Property(property="category", type="string", example="World"),
     *             @OA\Property(property="image", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News article updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="News article updated"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News article not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $news = News::find($id);
        if (!$news) {
            return response()->json(['success' => false, 'message' => 'News article not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->only(['title', 'content', 'category']);
        if ($request->hasFile('image')) {
            if ($news->image) Storage::disk('public')->delete($news->image);
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);
        return response()->json([
            'success' => true,
            'message' => 'News article updated successfully',
            'data' => $news
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/news/{id}",
     *     summary="Delete a news article",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News article deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="News article deleted")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News article not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $news = News::find($id);
        if (!$news) {
            return response()->json(['success' => false, 'message' => 'News article not found'], 404);
        }

        if ($news->image) Storage::disk('public')->delete($news->image);
        $news->delete();

        return response()->json([
            'success' => true,
            'message' => 'News article deleted successfully'
        ]);
    }

    /**
     * @OA\Post(
     *     path="/news/{id}/save",
     *     summary="Save a news article (bookmark)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News article saved/unsaved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="saved", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Saved")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News article not found"
     *     )
     * )
     */
    public function save($id)
    {
        $user = Auth::user();
        $news = News::find($id);
        if (!$news) {
            return response()->json(['success' => false, 'message' => 'News article not found'], 404);
        }

        $saved = $user->savedNews()->toggle($id);
        $isSaved = count($saved['attached']) > 0;

        return response()->json([
            'success' => true,
            'saved' => $isSaved,
            'message' => $isSaved ? 'Saved' : 'Unsaved'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/saved",
     *     summary="Get saved (bookmarked) news articles",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of saved news articles",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function saved()
    {
        $saved = Auth::user()->savedNews()->latest()->get();
        return response()->json(['success' => true, 'data' => $saved]);
    }
}