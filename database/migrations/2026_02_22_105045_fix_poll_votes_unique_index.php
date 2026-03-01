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
        Schema::table('poll_votes', function (Blueprint $table) {
            // Add a temporary index for user_id so the foreign key can use it
            $table->index('user_id');

            // Drop old unique index
            $table->dropUnique(['user_id', 'post_id']);

            // Add new unique index: user can only vote once PER OPTION
            $table->unique(['user_id', 'poll_option_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('poll_votes', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'poll_option_id']);
            $table->unique(['user_id', 'post_id']);
        });
    }
};
