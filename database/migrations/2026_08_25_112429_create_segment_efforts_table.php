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
        Schema::create('segment_efforts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('segment_id')->constrained()->onDelete('cascade');
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('duration_seconds');
            $table->timestamp('achieved_at');
            $table->timestamps();

            $table->unique(['segment_id', 'activity_id']);
            $table->index(['segment_id', 'duration_seconds']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segment_efforts');
    }
};
