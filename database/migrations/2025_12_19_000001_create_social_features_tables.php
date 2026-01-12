<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
        Schema::table('activities', function (Blueprint $table) {
            $table->json('tagged_users')->nullable()->after('media'); // List of user IDs or names
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('likes');
        
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('tagged_users');
        });
    }
};
