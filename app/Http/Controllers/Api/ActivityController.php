<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class ActivityController extends Controller
{
    /**
     * Store or update an activity from the mobile app.
     */
    public function store(Request $request)
    {
        // Validation matching app data
        $validator = Validator::make($request->all(), [
            'id' => 'required|string', // Mobile App ID (UUID)
            'activityTitle' => 'required|string',
            'sport' => 'required|string',
            'createdAt' => 'required|date',
            'distanceInMeters' => 'required|numeric',
            'durationInSeconds' => 'required|integer',
            'routePoints' => 'nullable|array',
            'calories' => 'nullable|numeric',
            'privacy' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        // Resolve Tagged Users if provided
        $taggedUsers = [];
        if ($request->has('taggedPartnerIds')) {
            $taggedIds = $request->taggedPartnerIds; // Array of IDs
            if (is_array($taggedIds) && count($taggedIds) > 0) {
                $taggedUsers = \App\Models\User::whereIn('id', $taggedIds) // Assuming app sends DB IDs, or change col to google_id
                    ->select('id', 'name', 'avatar')
                    ->get()
                    ->toArray();
            }
        }

        // Create or Update based on 'app_id'
        $activity = Activity::updateOrCreate(
            [
                'app_id' => $request->id,
                'user_id' => $user->id,
            ],
            [
                'title' => $request->activityTitle,
                'sport_type' => $request->sport,
                'start_time' => Carbon::parse($request->createdAt),
                'distance' => $request->distanceInMeters,
                'duration' => $request->durationInSeconds,
                'calories' => $request->calories ?? 0,
                'polylines' => $request->routePoints ?? [], // Store raw lat/lng list
                'privacy' => $request->privacy ?? 'public',
                'description' => $request->notes,
                'mood' => $request->mood,
                'media' => $request->mediaPaths ?? [],
                'tagged_users' => $taggedUsers,
            ]
        );

        return response()->json([
            'message' => 'Activity synced successfully',
            'activity_id' => $activity->id
        ], 200);
    }

    /**
     * Get list of user activities.
     */
    public function index(Request $request)
    {
        $activities = $request->user()->activities()
            ->latest('start_time')
            ->paginate(20);

        return response()->json($activities);
    }
}
