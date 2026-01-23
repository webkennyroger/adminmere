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
            $table->text('bio')->nullable()->after('image');
            $table->string('gender')->nullable()->after('bio');
            $table->string('birth_date')->nullable()->after('gender'); // String for simplicity to match Flutter format 'DD/MM/YYYY' or date if parsed
            $table->string('height')->nullable()->after('birth_date');
            $table->string('weight')->nullable()->after('height');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['bio', 'gender', 'birth_date', 'height', 'weight']);
        });
    }
};
