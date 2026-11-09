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
        Schema::table('users', function (Blueprint $table) {
            $table->string('publisher_company')->nullable()->after('membership_expires_at');
            $table->string('publisher_status')->default('pending')->after('publisher_company'); // pending, approved, rejected
            $table->text('publisher_bio')->nullable()->after('publisher_status');
            $table->text('publisher_rejection_reason')->nullable()->after('publisher_bio');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->string('publisher_name')->nullable()->after('author_name');
            $table->string('approval_status')->default('approved')->after('is_published'); // approved, pending, rejected
            $table->text('rejection_reason')->nullable()->after('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'publisher_name', 'approval_status', 'rejection_reason']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['publisher_company', 'publisher_status', 'publisher_bio', 'publisher_rejection_reason']);
        });
    }
};
