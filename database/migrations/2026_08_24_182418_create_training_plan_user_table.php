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
        Schema::create('training_plan_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('training_plan_id')->constrained()->onDelete('cascade');
            $table->timestamp('started_at');
            $table->unsignedTinyInteger('current_week')->default(1);
            $table->unsignedTinyInteger('current_day')->default(1);
            $table->string('status')->default('active'); // active, completed, abandoned
            $table->timestamps();

            $table->unique(['user_id', 'training_plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_plan_user');
    }
};
