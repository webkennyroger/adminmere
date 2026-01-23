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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role')->default('user'); // Replaced is_admin
            $table->string('plan')->default('free');
            $table->string('status')->default('active');
            $table->string('phone')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->text('bio')->nullable(); // Consolidated
            $table->string('gender')->nullable(); // Consolidated
            $table->string('birth_date')->nullable(); // Consolidated
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('height')->nullable(); // Consolidated
            $table->string('weight')->nullable(); // Consolidated
            $table->string('image')->nullable();
            $table->string('cover_image')->nullable(); // Consolidated
            $table->string('mere')->nullable();
            $table->string('instagram')->nullable();
            $table->string('x')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
