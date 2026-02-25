<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get suggested users to follow.
     */
    public function suggested(Request $request)
    {
        $user = $request->user();

        // Get IDs of users already followed
        $followingIds = $user->following()->pluck('following_id')->toArray();

        // Suggest users not followed and not the current user
        $suggested = User::whereNotIn('id', $followingIds)
            ->where('id', '!=', $user->id)
            ->with('profile')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $suggested->map(function ($u) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'nickname' => $u->profile?->nickname ?? $u->id,
                    'avatar' => $u->image_url,
                    'status' => 'Em destaque', // Label from UI
                    'city' => $u->profile?->city ?? 'Brasil',
                ];
            }),
        ]);
    }

    /**
     * Get the list of users the current user is following.
     */
    public function following(Request $request)
    {
        $user = $request->user();

        $following = $user->following()
            ->with(['profile'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $following->map(function ($u) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'nickname' => $u->profile?->nickname ?? $u->id,
                    'avatar' => $u->image_url,
                    'city' => $u->profile?->city ?? 'Brasil',
                ];
            }),
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
                'message' => 'You cannot follow yourself',
            ], 400);
        }

        if ($user->following()->where('following_id', $userToFollow->id)->exists()) {
            $user->following()->detach($userToFollow->id);
            $isFollowing = false;
        } else {
            $user->following()->attach($userToFollow->id);
            $isFollowing = true;
        }

        return response()->json([
            'success' => true,
            'is_following' => $isFollowing,
        ]);
    }

    /**
     * Get user profile details and their activities.
     */
    public function profile(Request $request, $id)
    {
        $currentUser = $request->user();
        $user = User::with(['profile'])->findOrFail($id);

        $activities = $user->activities()
            ->with(['likes', 'user.profile'])
            ->latest('start_time')
            ->limit(20)
            ->get();

        // Calcula estatísticas semanais (últimos 7 dias)
        $weeklyStats = $this->getWeeklyStats($user);

        // Busca troféus/achievements
        $achievements = $this->getAchievements($user);

        $activityController = new ActivityController;

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'nickname' => $user->profile->nickname ?? $user->id,
                    'avatar' => $user->image_url,
                    'city' => $user->profile->city ?? 'Brasil',
                    'surname' => $user->profile->last_name ?? '',
                    'bio' => $user->profile->bio ?? '',
                    'is_following' => $currentUser->following()->where('following_id', $user->id)->exists(),
                    'is_pro' => true, // Você pode adicionar campo real no modelo
                ],
                'stats' => [
                    'activities_count' => $user->activities()->count(),
                    'followers_count' => $user->followers()->count(),
                    'following_count' => $user->following()->count(),
                    'total_distance_km' => $user->activities()->sum('distance') ?? 0,
                    'total_time_seconds' => $user->activities()->sum('duration') ?? 0,
                ],
                'weekly_stats' => $weeklyStats,
                'achievements' => $achievements,
                'activities' => $activities->map(function ($activity) use ($currentUser, $activityController) {
                    return $activityController->formatActivity($activity, $currentUser);
                }),
            ],
        ]);
    }

    /**
     * Calcula estatísticas da última semana.
     */
    private function getWeeklyStats($user)
    {
        $now = \Carbon\Carbon::now();
        $sevenDaysAgo = $now->copy()->subDays(7);

        $activities = $user->activities()
            ->whereBetween('start_time', [$sevenDaysAgo, $now])
            ->get();

        $totalDistance = $activities->sum('distance') ?? 0;
        $totalDuration = $activities->sum('duration') ?? 0; // segundos
        $totalElevation = $activities->sum('elevation_gain') ?? 0;

        // Agrupa por dia da semana
        $dailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $dayActivities = $activities->filter(function ($a) use ($day) {
                return \Carbon\Carbon::parse($a->start_time)->format('Y-m-d') === $day->format('Y-m-d');
            });

            $dailyData[] = [
                'day' => $day->format('Y-m-d'),
                'day_name' => strtoupper($day->format('D')),
                'distance' => round($dayActivities->sum('distance') / 1000, 2), // km
                'count' => $dayActivities->count(),
            ];
        }

        return [
            'period' => 'week',
            'total_distance_km' => round($totalDistance / 1000, 2),
            'total_time_hours' => round($totalDuration / 3600, 2),
            'total_time_formatted' => $this->formatSeconds($totalDuration),
            'total_elevation_m' => round($totalElevation),
            'daily_data' => $dailyData,
            'activities_count' => $activities->count(),
        ];
    }

    /**
     * Obtém achievements/troféus do usuário.
     */
    private function getAchievements($user)
    {
        $achievements = [];

        // Badge de 75 atividades
        if ($user->activities()->count() >= 75) {
            $achievements[] = ['id' => 1, 'name' => '75', 'label' => 'ATIVIDADE', 'color' => 'green', 'unlocked' => true];
        }

        // Badge de 50 atividades
        if ($user->activities()->count() >= 50) {
            $achievements[] = ['id' => 2, 'name' => '50', 'label' => 'ATIVIDADE', 'color' => 'yellow', 'unlocked' => true];
        }

        // Badge de 40 atividades
        if ($user->activities()->count() >= 40) {
            $achievements[] = ['id' => 3, 'name' => '40', 'label' => 'ATIVIDADE', 'color' => 'green', 'unlocked' => true];
        }

        // Placeholder para mais badges
        while (count($achievements) < 4) {
            $achievements[] = ['id' => count($achievements) + 1, 'locked' => true, 'color' => 'gray'];
        }

        return [
            'total_count' => $user->activities()->count(),
            'unlocked_count' => count(array_filter($achievements, fn($a) => $a['unlocked'] ?? false)),
            'achievements' => $achievements,
        ];
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user()->load('profile');

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'image' => 'nullable|image|max:10240', // 10MB max
            'cover_image' => 'nullable|image|max:10240', // 10MB max
            'nickname' => 'sometimes|string|max:30|alpha_dash|unique:profiles,nickname,' . $user->id . ',user_id',
            'bio' => 'nullable|string|max:500',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        $user->save();

        // Update or create profile
        $profile = $user->profile ?? new \App\Models\Profile(['user_id' => $user->id]);

        if ($request->has('surname')) {
            $profile->last_name = $request->surname;
        }
        if ($request->has('last_name')) {
            $profile->last_name = $request->last_name;
        } // Support both
        if ($request->has('phone')) {
            $profile->phone = $request->phone;
        }
        if ($request->has('location')) {
            $profile->city = $request->location;
        }
        if ($request->has('city')) {
            $profile->city = $request->city;
        } // Support both
        if ($request->has('nickname')) {
            $profile->nickname = $request->nickname;
        }
        if ($request->has('bio')) {
            $profile->bio = $request->bio;
        }
        if ($request->has('gender')) {
            $profile->gender = $request->gender;
        }
        if ($request->has('birth_date')) {
            $profile->birth_date = $request->birth_date;
        }
        if ($request->has('height')) {
            $profile->height = $request->height;
        }
        if ($request->has('weight')) {
            $profile->weight = $request->weight;
        }
        if ($request->has('settings')) {
            $currentSettings = $profile->settings ?? [];
            $newSettings = is_string($request->settings) ? json_decode($request->settings, true) : $request->settings;
            $profile->settings = array_merge($currentSettings, $newSettings);
        }

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($profile->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->image);
            }

            $path = $request->file('image')->store('profiles', 'public');
            $profile->image = $path;
        }

        // Handle Cover Image Upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($profile->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->cover_image);
            }

            $path = $request->file('cover_image')->store('covers', 'public');
            $profile->cover_image = $path;
        }

        $profile->save();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->image_url,
                'cover_url' => $user->cover_url, // Return cover URL
                'profile' => $profile,
            ],
            'message' => 'Profile updated successfully',
        ]);
    }

    /**
     * Formata segundos em formato legível (HhMm).
     */
    private function formatSeconds($seconds)
    {
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        return sprintf('%dh %dm', $hours, $minutes);
    }
}
