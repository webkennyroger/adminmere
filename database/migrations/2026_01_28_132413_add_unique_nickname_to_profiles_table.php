<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add unique constraint to nickname column in profiles table.
     * This ensures each user has a unique @handle for their profile URL.
     */
    public function up(): void
    {
        // First, ensure all existing nicknames are unique
        // For duplicates, append user_id to make them unique
        DB::statement("
            UPDATE profiles p1
            SET nickname = CONCAT(nickname, '_', user_id)
            WHERE EXISTS (
                SELECT 1 FROM profiles p2
                WHERE p2.nickname = p1.nickname
                AND p2.id < p1.id
            )
            AND nickname IS NOT NULL
        ");
        
        // Now add the unique constraint
        Schema::table('profiles', function (Blueprint $table) {
            $table->unique('nickname');
            $table->index('nickname'); // Add index for faster lookups
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropUnique(['nickname']);
            $table->dropIndex(['nickname']);
        });
    }
};
