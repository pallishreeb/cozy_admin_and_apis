<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('otp')->nullable()->after('email');
            $table->string('mobile_number')->nullable()->after('otp');
            $table->string('address')->nullable()->after('mobile_number');
            $table->string('device_token')->nullable()->after('address');
            $table->boolean('isNotificationAllowed')->default(true)->after('device_token');
            $table->boolean('isAdmin')->default(false)->after('isNotificationAllowed'); // Add isAdmin field after email
            $table->timestamp('otp_valid_until')->nullable()->after('isAdmin'); // Add otp_valid_until field after isAdmin
            $table->string('zipcode')->nullable()->after('isAdmin');
            $table->string('city')->nullable()->after('zipcode');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('otp');
            $table->dropColumn('mobile_number');
            $table->dropColumn('address');
            $table->dropColumn('device_token');
            $table->dropColumn('isNotificationAllowed');
            $table->dropColumn('isAdmin');
            $table->dropColumn('otp_valid_until');
            $table->dropColumn('zipcode');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
        });
    }
};
