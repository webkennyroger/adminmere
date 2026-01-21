<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Challenge;

class StatsController extends Controller
{
    /**
     * Get user's dashboard statistics
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        
        // Get today's activities
        $todayActivities = $user->activities()
            ->whereDate('start_time', $today)
            ->get();
        
        // Calculate today's stats
        $todayDistance = $todayActivities->sum('distance') / 1000; // km
        $todayDuration = $todayActivities->sum('duration'); // seconds
        $todayCalories = $todayActivities->sum('calories');
        
        // Daily goal (example: 10km)
        $dailyGoal = 10; // km
        $dailyProgress = min(($todayDistance / $dailyGoal) * 100, 100);
        
        // Get this month's activities
        $monthActivities = $user->activities()
            ->where('start_time', '>=', $startOfMonth)
            ->get();
        
        // Calculate month stats
        $monthDistance = $monthActivities->sum('distance') / 1000; // km
        $monthDuration = $monthActivities->sum('duration'); // seconds
        $monthCalories = $monthActivities->sum('calories');
        
        // Calculate average speed
        $avgSpeed = $monthDuration > 0 
            ? ($monthDistance / ($monthDuration / 3600)) 
            : 0;
        
        // Get calendar data for current month
        $calendarData = $this->getMonthCalendar($user, $startOfMonth);
        
        // Get conquered challenges count
        $conqueredChallenges = $user->challenges()
            ->wherePivot('completed', true)
            ->count();
        
        return response()->json([
            'success' => true,
            'data' => [
                'daily_goal' => [
                    'progress' => round($dailyProgress, 0),
                    'distance_km' => round($todayDistance, 1),
                    'calories' => round($todayCalories, 0),
                ],
                'stats' => [
                    'distance_km' => round($monthDistance, 1),
                    'time_hours' => round($monthDuration / 3600, 2),
                    'time_formatted' => $this->formatDuration($monthDuration),
                    'speed_kmh' => round($avgSpeed, 1),
                    'calories' => round($monthCalories, 0),
                    'speed_change' => '+1.5', // Mock data
                    'calories_change' => '+12', // Mock data
                ],
                'calendar' => $calendarData,
                'conquered_challenges' => $conqueredChallenges,
            ]
        ]);
    }
    
    /**
     * Get calendar data for a month
     */
    private function getMonthCalendar($user, $startDate)
    {
        $days = [];
        $today = Carbon::today();
        $startOfWeek = $today->copy()->startOfWeek(Carbon::SUNDAY);
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $dayActivities = $user->activities()
                ->whereDate('start_time', $date)
                ->get();
            
            $days[] = [
                'date' => $date->format('Y-m-d'),
                'day_name' => strtoupper($date->locale('pt_BR')->translatedFormat('D')),
                'day_number' => $date->day,
                'has_activity' => $dayActivities->count() > 0,
                'is_today' => $date->isToday(),
            ];
        }
        
        return [
            'month' => strtoupper($startDate->locale('pt_BR')->monthName),
            'year' => $startDate->year,
            'days' => $days,
        ];
    }
    
    /**
     * Get user's active challenges with progress (challenges they have joined)
     */
    public function activeChallenges(Request $request)
    {
        $user = $request->user();
        
        $challenges = $user->challenges()
            ->wherePivot('completed', false)
            ->where('end_date', '>=', Carbon::now())
            ->with('category')
            ->get()
            ->map(function($challenge) use ($user) {
                // Calculate progress
                $userProgress = $user->activities()
                    ->where('start_time', '>=', $challenge->start_date)
                    ->where('start_time', '<=', $challenge->end_date)
                    ->sum('distance') / 1000; // km
                
                $progress = min(($userProgress / $challenge->goal_km) * 100, 100);
                
                return [
                    'id' => $challenge->id,
                    'title' => $challenge->title,
                    'description' => $challenge->description,
                    'goal_km' => $challenge->goal_km,
                    'current_km' => round($userProgress, 1),
                    'progress' => round($progress, 0),
                    'tier' => $this->getTier($progress),
                    'is_featured' => $challenge->is_featured,
                    'end_date' => $challenge->end_date,
                    'time_remaining' => $this->getTimeRemaining($challenge->end_date),
                    'is_joined' => true,
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $challenges
        ]);
    }

    /**
     * Get all available challenges (even those not joined)
     */
    public function availableChallenges(Request $request)
    {
        $user = $request->user();
        $userChallengeIds = $user->challenges()->pluck('challenges.id')->toArray();
        
        $challenges = Challenge::where('end_date', '>=', Carbon::now())
            ->with('category')
            ->get()
            ->map(function($challenge) use ($user, $userChallengeIds) {
                $isJoined = in_array($challenge->id, $userChallengeIds);
                
                $data = [
                    'id' => $challenge->id,
                    'title' => $challenge->title,
                    'description' => $challenge->description,
                    'goal_km' => $challenge->goal_km,
                    'is_featured' => $challenge->is_featured,
                    'end_date' => $challenge->end_date,
                    'time_remaining' => $this->getTimeRemaining($challenge->end_date),
                    'is_joined' => $isJoined,
                    'category' => $challenge->category ? $challenge->category->name : 'Geral',
                ];

                if ($isJoined) {
                    $userProgress = $user->activities()
                        ->where('start_time', '>=', $challenge->start_date)
                        ->where('start_time', '<=', $challenge->end_date)
                        ->sum('distance') / 1000; // km
                    
                    $progress = min(($userProgress / $challenge->goal_km) * 100, 100);
                    $data['current_km'] = round($userProgress, 1);
                    $data['progress'] = round($progress, 0);
                    $data['tier'] = $this->getTier($progress);
                } else {
                    $data['current_km'] = 0;
                    $data['progress'] = 0;
                    $data['tier'] = 'PADRÃO';
                }

                return $data;
            });
        
        return response()->json([
            'success' => true,
            'data' => $challenges
        ]);
    }
    
    /**
     * Get user's tier/level information
     */
    public function userTier(Request $request)
    {
        $user = $request->user();
        
        // Calculate total activities count
        $totalActivities = $user->activities()->count();
        
        // Determine tier based on activities
        $tier = $this->calculateTier($totalActivities);
        
        return response()->json([
            'success' => true,
            'data' => [
                'current_tier' => $tier['current'],
                'next_tier' => $tier['next'],
                'season' => '04',
                'total_activities' => $totalActivities,
                'tiers' => [
                    ['name' => 'BRONZE', 'unlocked' => $totalActivities >= 10],
                    ['name' => 'PRATA', 'unlocked' => $totalActivities >= 25],
                    ['name' => 'OURO', 'unlocked' => $totalActivities >= 50],
                    ['name' => 'PLATINA', 'unlocked' => $totalActivities >= 100],
                ],
            ]
        ]);
    }
    
    /**
     * Calculate user tier based on activities
     */
    private function calculateTier($count)
    {
        if ($count >= 100) {
            return ['current' => 'PLATINA', 'next' => null];
        } elseif ($count >= 50) {
            return ['current' => 'OURO', 'next' => 'PLATINA'];
        } elseif ($count >= 25) {
            return ['current' => 'PRATA', 'next' => 'OURO'];
        } elseif ($count >= 10) {
            return ['current' => 'BRONZE', 'next' => 'PRATA'];
        }
        return ['current' => null, 'next' => 'BRONZE'];
    }
    
    /**
     * Get tier based on progress percentage
     */
    private function getTier($progress)
    {
        if ($progress >= 70) return 'ATIVO';
        if ($progress >= 50) return 'NÍVEL OURO';
        return 'PADRÃO';
    }
    
    /**
     * Format duration in seconds to HH:MM:SS
     */
    private function formatDuration($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        return sprintf('%02d:%02d', $hours, $minutes);
    }
    
    /**
     * Get time remaining until date
     */
    private function getTimeRemaining($endDate)
    {
        $end = Carbon::parse($endDate);
        $now = Carbon::now();
        
        if ($now->greaterThan($end)) {
            return '00:00:00';
        }
        
        $diff = $now->diff($end);
        return sprintf('%02d:%02d:%02d', $diff->h, $diff->i, $diff->s);
    }
}
