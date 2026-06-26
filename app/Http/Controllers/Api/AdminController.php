<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\News;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="/admin/users",
     *     summary="Get list of users",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of users")
     * )
     */
    public function users()
    {
        $users = User::latest()->get();
        return response()->json(['success' => true, 'data' => $users]);
    }

    /**
     * @OA\Post(
     *     path="/admin/users/{id}/role",
     *     summary="Change user role",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"role"},
     *             @OA\Property(property="role", type="string", enum={"admin","helper","reader"}, example="admin")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Role updated successfully")
     * )
     */
    public function updateRole(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'role' => 'required|in:admin,helper,reader',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user->syncRoles([$request->role]);
        return response()->json(['success' => true, 'message' => 'Role updated successfully']);
    }

    /**
     * @OA\Get(
     *     path="/admin/settings",
     *     summary="Get site settings",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Current site settings")
     * )
     */
    public function settings()
    {
        $setting = \App\Models\Setting::first();
        return response()->json(['success' => true, 'data' => $setting]);
    }

    /**
     * @OA\Post(
     *     path="/admin/settings",
     *     summary="Update site settings",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="site_name", type="string", example="News Portal")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Settings updated successfully")
     * )
     */
    public function updateSettings(Request $request)
    {
        $setting = \App\Models\Setting::first();
        if (!$setting) {
            $setting = \App\Models\Setting::create();
        }

        $setting->update($request->all());
        return response()->json(['success' => true, 'message' => 'Settings updated successfully']);
    }

    /**
     * @OA\Get(
     *     path="/admin/contacts",
     *     summary="Get all contact messages",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of contact messages")
     * )
     */
    public function contacts()
    {
        $contacts = Contact::with('user')->latest()->get();
        return response()->json(['success' => true, 'data' => $contacts]);
    }

    /**
     * @OA\Get(
     *     path="/admin/contacts/{id}",
     *     summary="Get contact message details",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Contact message details")
     * )
     */
    public function contactShow($id)
    {
        $contact = Contact::with('user')->find($id);
        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Contact not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $contact]);
    }

    /**
     * @OA\Patch(
     *     path="/admin/contacts/{id}/status",
     *     summary="Update contact message status",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", enum={"new","read","replied"}, example="read")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Status updated successfully")
     * )
     */
    public function updateContactStatus(Request $request, $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Contact not found'], 404);
        }

        $contact->update(['status' => $request->status]);
        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    /**
     * @OA\Patch(
     *     path="/admin/contacts/{id}/mark-read",
     *     summary="Mark contact message as read",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Message marked as read")
     * )
     */
    public function markContactRead($id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Contact not found'], 404);
        }

        $contact->update(['status' => 'read']);
        return response()->json(['success' => true, 'message' => 'Message marked as read']);
    }

    /**
     * @OA\Get(
     *     path="/admin/stats",
     *     summary="Get site statistics",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Site statistics")
     * )
     */
    public function stats()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'posts' => News::count(),
                'views' => News::sum('views'),
                'users' => User::count(),
                'comments' => \App\Models\Comment::count(),
            ]
        ]);
    }
}