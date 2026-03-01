<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Chat preferences table stores user-specific settings for each chat conversation.
     * This includes mute/archive status for individual conversations.
     */
    public function up(): void
    {
        // Only create if doesn't exist (since we already created it manually)
        if (! Schema::hasTable('chat_preferences')) {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_preferences');
    }
};
