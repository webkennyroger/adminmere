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
        // ACTIVITIES (Events/Workouts)
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('app_id')->nullable()->index(); // ID from the mobile app (UUID)
            $table->string('title')->nullable();
            $table->string('sport_type')->default('run');
            $table->dateTime('start_time')->nullable();
            $table->decimal('distance', 8, 2)->default(0); // in meters (Using decimal for precision)
            $table->integer('duration')->default(0); // in seconds
            $table->decimal('calories', 8, 2)->default(0);
            $table->json('polylines')->nullable(); // Route points
            $table->string('privacy')->default('public');
            $table->text('description')->nullable(); // notes
            $table->integer('mood')->nullable();
            $table->json('media')->nullable(); // array of image URLs
            $table->timestamps();
        });

        // SCHEDULES (Planned Events)
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->date('event_date');
            $table->time('event_time');
            $table->string('color', 7)->default('#3788d8'); // hex color code
            $table->timestamps();
        });
        
         // GOALS (Targets)
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('metric'); // users, sales, expenses, revenue
            $table->string('period'); // monthly, quarterly, semiannual, annual
            $table->decimal('target_value', 15, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('activities');
    }
};
