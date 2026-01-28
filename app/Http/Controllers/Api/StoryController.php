<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // IDs dos usuários que eu sigo
        $followingIds = $user->following()->pluck('following_id')->toArray();
        
        // Incluir meu própro ID
        $followingIds[] = $user->id;

        // Buscar usuários com stories ativos
        $usersWithStories = \App\Models\User::whereIn('id', $followingIds)
            ->whereHas('stories', function ($query) {
                $query->where('expires_at', '>', now());
            })
            ->with(['latestStory', 'profile'])
            ->get();

        $stories = $usersWithStories->map(function ($u) use ($user) {
            return [
                'user_id' => $u->id,
                'name' => $u->id === $user->id ? 'Seu story' : $u->name,
                'nickname' => $u->profile->nickname ?? $u->name,
                'avatar' => $u->image_url,
                'has_story' => true,
                'is_own' => $u->id === $user->id,
                'latest_story_image' => $u->latestStory->image_url,
                'expires_at' => $u->latestStory->expires_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $stories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB max
        ]);

        $user = $request->user();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stories', 'public');
            
            $story = $user->stories()->create([
                'image_url' => asset('storage/' . $path),
                'expires_at' => now()->addHours(24),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Story criado com sucesso',
                'data' => $story
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Nenhuma imagem enviada'
        ], 400);
    }
}
