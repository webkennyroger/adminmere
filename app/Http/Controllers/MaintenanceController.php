<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class MaintenanceController extends Controller
{
    public function seed()
    {
        try {
            // Run the seeder
            Artisan::call('db:seed', ['--force' => true]);

            // Get the output
            $output = Artisan::output();

            return response()->json([
                'status' => 'success',
                'message' => 'Database seeded successfully',
                'output' => $output,
            ]);
        } catch (\Exception $e) {
            Log::error('Seeding failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Seeding failed: '.$e->getMessage(),
            ], 500);
        }
    }
}
