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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['attachment_path', 'attachment_type']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->json('attachments')->nullable()->after('content');
        });

        Schema::table('group_messages', function (Blueprint $table) {
            $table->dropColumn(['attachment', 'attachment_type']);
        });

        Schema::table('group_messages', function (Blueprint $table) {
            $table->json('attachments')->nullable()->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('attachments');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->string('attachment_path')->nullable()->after('content');
            $table->string('attachment_type')->nullable()->after('attachment_path');
        });

        Schema::table('group_messages', function (Blueprint $table) {
            $table->dropColumn('attachments');
        });

        Schema::table('group_messages', function (Blueprint $table) {
            $table->string('attachment')->nullable();
            $table->string('attachment_type')->nullable();
        });
    }
};
