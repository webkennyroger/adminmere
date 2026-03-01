<?php

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;

class CheckActivitiesDebug extends Command
{
    protected $signature = 'debug:activities';

    protected $description = 'Debug activities polylines data';

    public function handle()
    {
        $activities = Activity::all();

        $this->info('Total activities: '.count($activities));

        foreach ($activities as $activity) {
            $this->line("\n---");
            $this->line("ID: {$activity->id}");
            $this->line("Title: {$activity->title}");
            $this->line("Distance: {$activity->distance}m");
            $this->line('Polylines: '.json_encode($activity->polylines));

            if (is_array($activity->polylines)) {
                if (isset($activity->polylines['points'])) {
                    $this->line("✓ Has 'points' field with ".count($activity->polylines['points']).' points');
                }
                if (isset($activity->polylines['summary_polyline'])) {
                    $this->line("✓ Has 'summary_polyline' field");
                }
            } elseif ($activity->polylines) {
                $this->line('⚠ Polylines is not array: '.gettype($activity->polylines));
            } else {
                $this->line('✗ Polylines is NULL');
            }
        }
    }
}
