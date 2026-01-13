<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get suggested users for the current user to follow.
     */
    public function suggested(Request $request)
    {
        $user = $request->user();
        
        // Get IDs of users already followed
        $followingIds = $user->following()->pluck('users.id');
        
        // Suggest users not followed and not the current user
        $suggested = User::whereNotIn('id', $followingIds)
            ->where('id', '!=', $user->id)
            ->with('profile')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $suggested->map(function($u) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'avatar' => $u->image_url,
                    'status' => 'Em destaque', // Label from UI
                    'city' => $u->profile->city ?? 'Brasil',
                ];
            })
        ]);
    }

    /**
     * Follow/Unfollow a user.
     */
    public function toggleFollow(Request $request, $id)
    {
        $user = $request->user();
        $userToFollow = User::findOrFail($id);

        if ($user->id === $userToFollow->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot follow yourself'
            ], 400);
        }

        if ($user->following()->where('user_id', $userToFollow->id)->exists()) {
            $user->following()->detach($userToFollow->id);
            $isFollowing = false;
        } else {
            $user->following()->attach($userToFollow->id);
            $isFollowing = true;
        }

        return response()->json([
            'success' => true,
            'is_following' => $isFollowing
        ]);
    }
}
