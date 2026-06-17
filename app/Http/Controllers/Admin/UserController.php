<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)  
    {
       
        if (!Auth::user()->hasRole('admin')) {
            if ($request->ajax()) {
                return response()->json(['error' => 'No rights'], 403);
            }
            return redirect()->back()->with('error', 'You do not have permission to change roles.');
        }
        
    
        $user->syncRoles([$request->role]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'The role has been updated');
    }
}