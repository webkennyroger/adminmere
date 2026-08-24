<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingPlan;
use App\Models\TrainingPlanWorkout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrainingPlanController extends Controller
{
    /**
     * List all available training plans, flagging which ones the user is enrolled in.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $enrolledPlanIds = $user->trainingPlans()->pluck('training_plans.id')->toArray();

        $plans = TrainingPlan::query()->get()->map(function (TrainingPlan $plan) use ($enrolledPlanIds) {
            return [
                'id' => $plan->id,
                'title' => $plan->title,
                'description' => $plan->description,
                'sport_type' => $plan->sport_type,
                'weeks' => $plan->weeks,
                'level' => $plan->level,
                'is_enrolled' => in_array($plan->id, $enrolledPlanIds),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $plans,
        ]);
    }

    /**
     * Return a single plan's full details, including every scheduled workout.
     */
    public function show(Request $request, TrainingPlan $trainingPlan): JsonResponse
    {
        $user = $request->user();
        $isEnrolled = $user->trainingPlans()->where('training_plans.id', $trainingPlan->id)->exists();

        $workouts = $trainingPlan->workouts()
            ->orderBy('week_number')
            ->orderBy('day_number')
            ->get()
            ->map(fn (TrainingPlanWorkout $workout) => [
                'id' => $workout->id,
                'plan_id' => $trainingPlan->id,
                'plan_title' => $trainingPlan->title,
                'week_number' => $workout->week_number,
                'day_number' => $workout->day_number,
                'title' => $workout->title,
                'steps' => $workout->steps,
            ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $trainingPlan->id,
                'title' => $trainingPlan->title,
                'description' => $trainingPlan->description,
                'sport_type' => $trainingPlan->sport_type,
                'weeks' => $trainingPlan->weeks,
                'level' => $trainingPlan->level,
                'is_enrolled' => $isEnrolled,
                'workouts' => $workouts,
            ],
        ]);
    }

    /**
     * Enroll the authenticated user in a training plan.
     */
    public function enroll(Request $request, TrainingPlan $trainingPlan): JsonResponse
    {
        $user = $request->user();

        if (! $user->trainingPlans()->where('training_plans.id', $trainingPlan->id)->exists()) {
            $user->trainingPlans()->attach($trainingPlan->id, [
                'started_at' => now(),
                'current_week' => 1,
                'current_day' => 1,
                'status' => 'active',
            ]);
        }

        return response()->json([
            'success' => true,
            'is_enrolled' => true,
        ]);
    }

    /**
     * Remove the authenticated user from a training plan.
     */
    public function unenroll(Request $request, TrainingPlan $trainingPlan): JsonResponse
    {
        $request->user()->trainingPlans()->detach($trainingPlan->id);

        return response()->json([
            'success' => true,
            'is_enrolled' => false,
        ]);
    }

    /**
     * Return the workout scheduled for today on the user's active plan, if any.
     */
    public function todayWorkout(Request $request): JsonResponse
    {
        $user = $request->user();

        $activePlan = $user->trainingPlans()
            ->wherePivot('status', 'active')
            ->first();

        if (! $activePlan) {
            return response()->json([
                'success' => true,
                'data' => null,
            ]);
        }

        $workout = TrainingPlanWorkout::where('training_plan_id', $activePlan->id)
            ->where('week_number', $activePlan->pivot->current_week)
            ->where('day_number', $activePlan->pivot->current_day)
            ->first();

        return response()->json([
            'success' => true,
            'data' => $workout ? [
                'id' => $workout->id,
                'plan_id' => $activePlan->id,
                'plan_title' => $activePlan->title,
                'week_number' => $workout->week_number,
                'day_number' => $workout->day_number,
                'title' => $workout->title,
                'steps' => $workout->steps,
            ] : null,
        ]);
    }

    /**
     * Advance the user's active plan to the next day (week 1-7 cycle), marking
     * the plan completed once the last week's workouts are done.
     */
    public function completeToday(Request $request): JsonResponse
    {
        $user = $request->user();

        $activePlan = $user->trainingPlans()
            ->wherePivot('status', 'active')
            ->first();

        if (! $activePlan) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum plano ativo.',
            ], 404);
        }

        $currentWeek = $activePlan->pivot->current_week;
        $currentDay = $activePlan->pivot->current_day;

        $nextDay = $currentDay + 1;
        $nextWeek = $currentWeek;
        if ($nextDay > 7) {
            $nextDay = 1;
            $nextWeek++;
        }

        $isCompleted = $nextWeek > $activePlan->weeks;

        $user->trainingPlans()->updateExistingPivot($activePlan->id, [
            'current_week' => $isCompleted ? $currentWeek : $nextWeek,
            'current_day' => $isCompleted ? $currentDay : $nextDay,
            'status' => $isCompleted ? 'completed' : 'active',
        ]);

        return response()->json([
            'success' => true,
            'status' => $isCompleted ? 'completed' : 'active',
        ]);
    }
}
