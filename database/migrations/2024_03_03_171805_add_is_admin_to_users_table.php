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
            $table->boolean('isAdmin')->default(false)->after('email'); // Add isAdmin field after email
            $table->timestamp('otp_valid_until')->nullable()->after('isAdmin'); // Add otp_valid_until field after isAdmin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('otp_valid_until');
            $table->dropColumn('isAdmin');
        });
    }
};
