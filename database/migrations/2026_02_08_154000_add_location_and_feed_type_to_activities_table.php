<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            if (!Schema::hasColumn('activities', 'location')) {
                $table->string('location')->nullable()->after('sport_type');
            }
            if (!Schema::hasColumn('activities', 'feed_type')) {
                $table->string('feed_type')->default('personal')->after('privacy'); // 'personal', 'community', 'feed'
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['location', 'feed_type']);
        });
    }
};
