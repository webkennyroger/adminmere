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
        // Add type column to posts if not exists
        if (!Schema::hasColumn('posts', 'type')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('type')->default('post')->after('user_id'); // 'post', 'poll'
                $table->timestamp('poll_expires_at')->nullable()->after('privacy');
            });
        }

        Schema::create('poll_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('option_text');
            $table->unsignedInteger('votes_count')->default(0);
            $table->timestamps();
        });

        Schema::create('poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('poll_option_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'post_id']); // One vote per user per poll
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poll_votes');
        Schema::dropIfExists('poll_options');
        
        if (Schema::hasColumn('posts', 'type')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn(['type', 'poll_expires_at']);
            });
        }
    }
};
