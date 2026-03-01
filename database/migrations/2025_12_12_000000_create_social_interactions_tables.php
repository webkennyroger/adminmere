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
        // Notifications Table (Standard Laravel)
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // Followers Table
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('following_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['follower_id', 'following_id']);
        });

        // Comments Table (Polymorphic)
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade'); // For replies
            $table->text('body');
            $table->morphs('commentable'); // activity_id, etc.
            $table->timestamps();
        });

        // Likes Table (Polymorphic)
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('likeable');
            $table->timestamps();
            $table->unique(['user_id', 'likeable_id', 'likeable_type']);
        });

        // Add tagged_users to activities
        // Make sure activities table exists before running this part (it does in previous migrations)
        if (Schema::hasTable('activities')) {
            Schema::table('activities', function (Blueprint $table) {
                if (! Schema::hasColumn('activities', 'tagged_users')) {
                    $table->json('tagged_users')->nullable()->after('media'); // List of user IDs or names
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('activities')) {
            Schema::table('activities', function (Blueprint $table) {
                $table->dropColumn('tagged_users');
            });
        }

        Schema::dropIfExists('likes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('followers');
        Schema::dropIfExists('notifications');
    }
};
