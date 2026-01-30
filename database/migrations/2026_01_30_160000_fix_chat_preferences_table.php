<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the table if it exists to ensure clean state and fix connection/column issues
        Schema::dropIfExists('chat_preferences');

        // Recreate it with correct structure
        Schema::create('chat_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('peer_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_muted')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->timestamps();

            // Ensure unique combination of user_id and peer_id
            $table->unique(['user_id', 'peer_id'], 'unique_user_peer');
            
            // Index for faster queries
            $table->index('user_id');
            $table->index('peer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_preferences');
    }
};
