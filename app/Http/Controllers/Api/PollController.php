<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class PollController extends Controller
{
    /**
     * Store a newly created poll in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'expiresAt' => 'nullable|date',
            'privacy' => 'nullable|in:public,friends,private',
            'feedType' => 'nullable|string',
            'isMandatory' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        // Create Poll (as a Post with type='poll')
        $poll = Post::create([
            'user_id' => $user->id,
            'title' => $request->question,
            'content' => '',
            'type' => 'poll',
            'privacy' => $request->privacy ?? 'public',
            'feed_type' => $request->feedType ?? 'personal',
            'poll_expires_at' => $request->expiresAt ? Carbon::parse($request->expiresAt) : null,
            'is_mandatory' => $request->isMandatory ?? false,
        ]);

        foreach ($request->options as $optionText) {
            $poll->pollOptions()->create([
                'option_text' => $optionText,
                'votes_count' => 0
            ]);
        }

        // Eager load relationships for formatting
        $poll->load(['user', 'pollOptions', 'pollVotes', 'likes']);

        return response()->json([
            'success' => true,
            'message' => 'Enquete criada com sucesso',
            'data' => $this->formatPoll($poll, $user),
        ], 201);
    }

    /**
     * Remove the specified poll.
     */
    public function destroy(Request $request, $id)
    {
        $cleanId = str_replace(['post_', 'poll_'], '', $id);

        $poll = Post::where('id', $cleanId)->where('type', 'poll')->firstOrFail();

        if ($poll->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $poll->delete();

        return response()->json([
            'success' => true,
            'message' => 'Enquete removida com sucesso',
        ]);
    }

    /**
     * Vote on the specified poll.
     */
    public function vote(Request $request, $id)
    {
        $cleanId = str_replace(['post_', 'poll_'], '', $id);
        $request->validate(['option_id' => 'required|exists:poll_options,id']);

        $poll = Post::where('id', $cleanId)->where('type', 'poll')->firstOrFail();
        $user = $request->user();

        if ($poll->hasVoted($user)) {
            return response()->json(['success' => false, 'message' => 'Você já votou nesta enquete'], 400);
        }

        if ($poll->poll_expires_at && $poll->poll_expires_at->isPast()) {
            return response()->json(['success' => false, 'message' => 'Enquete expirada'], 400);
        }

        $option = $poll->pollOptions()->find($request->option_id);

        $poll->pollVotes()->create([
            'user_id' => $user->id,
            'poll_option_id' => $option->id
        ]);

        $option->increment('votes_count');
        $poll->increment('total_votes');

        return response()->json([
            'success' => true,
            'data' => $this->formatPoll($poll->refresh(), $user)
        ]);
    }

    /**
     * Toggle like on poll.
     */
    public function toggleLike(Request $request, $id)
    {
        $cleanId = str_replace(['post_', 'poll_'], '', $id);
        $poll = Post::findOrFail($cleanId);
        $user = $request->user();

        $existingLike = $poll->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $isLiked = false;
        } else {
            $poll->likes()->create(['user_id' => $user->id]);
            $isLiked = true;
        }

        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $poll->likes()->count(),
        ]);
    }

    private function formatPoll($post, $user)
    {
        $hasVoted = $post->pollVotes->where('user_id', $user->id)->isNotEmpty();
        $totalVotes = $post->pollVotes->count();

        $pollData = [
            'expiresAt' => $post->poll_expires_at ? $post->poll_expires_at->toIso8601String() : null,
            'isMandatory' => (bool)$post->is_mandatory,
            'isExpired' => $post->poll_expires_at && $post->poll_expires_at->isPast(),
            'hasVoted' => $hasVoted,
            'totalVotes' => $totalVotes,
            'options' => $post->pollOptions->map(function ($opt) use ($user, $post, $totalVotes) {
                return [
                    'id' => (string) $opt->id,
                    'text' => $opt->option_text,
                    'votes' => $opt->votes_count,
                    'percentage' => $totalVotes > 0 ? round(($opt->votes_count / $totalVotes) * 100) : 0,
                    'isUserVote' => $post->pollVotes->where('user_id', $user->id)->where('poll_option_id', $opt->id)->isNotEmpty(),
                    'voterAvatars' => []
                ];
            })->values()
        ];

        return [
            'id' => 'poll_' . $post->id,
            'type' => 'poll',
            'title' => $post->title,
            'user_id' => (string) $post->user_id,
            'userName' => $post->user->name,
            'userAvatarUrl' => $post->user->image_url,
            'createdAt' => $post->created_at->toIso8601String(),
            'pollData' => $pollData,
            'likes' => $post->likes->count(),
            'isLiked' => $post->likes->contains('user_id', $user->id),
            'commentsList' => [], // TODO: Add comments later if needed
            'shares' => 0,
            'privacy' => $post->privacy,
        ];
    }
}
