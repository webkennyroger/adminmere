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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('role')->default('user')->after('user_id');
        });

        // Migrate existing admins
        \Illuminate\Support\Facades\DB::table('profiles')
            ->where('is_admin', true)
            ->update(['role' => 'admin']);

        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('user_id');
        });

        // Restore admins
        \Illuminate\Support\Facades\DB::table('profiles')
            ->where('role', 'admin')
            ->update(['is_admin' => true]);

        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
