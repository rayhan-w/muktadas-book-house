<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'publisher_plan')) {
                $table->string('publisher_plan')->nullable()->after('publisher_rejection_reason');
            }
            if (!Schema::hasColumn('users', 'publisher_expires_at')) {
                $table->timestamp('publisher_expires_at')->nullable()->after('publisher_plan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['publisher_plan', 'publisher_expires_at']);
        });
    }
};
