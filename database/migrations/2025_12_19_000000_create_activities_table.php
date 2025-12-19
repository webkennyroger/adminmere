<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('app_id')->nullable()->index(); // ID from the mobile app (UUID)
            $table->string('title')->nullable();
            $table->string('sport_type')->default('run');
            $table->dateTime('start_time')->nullable();
            $table->double('distance')->default(0); // in meters
            $table->integer('duration')->default(0); // in seconds
            $table->double('calories')->default(0);
            $table->json('polylines')->nullable(); // Route points
            $table->string('privacy')->default('public');
            $table->text('description')->nullable(); // notes
            $table->integer('mood')->nullable();
            $table->json('media')->nullable(); // array of image URLs
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
