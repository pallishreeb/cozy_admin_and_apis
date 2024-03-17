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
        Schema::table('providers', function (Blueprint $table) {
            $table->string('zipcode')->nullable()->after('address');
            $table->string('city')->nullable()->after('zipcode');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
            $table->json('working_hours')->nullable()->after('country');
            $table->string('timezone')->nullable()->after('working_hours');
            $table->boolean('business_hours_enabled')->default(true);
            $table->string('skills')->nullable()->after('business_hours_enabled');
            $table->string('device_token')->nullable()->after('email');
            $table->boolean('isNotificationAllowed')->default(true)->after('device_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('zipcode');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('working_hours');
            $table->dropColumn('timezone');
            $table->dropColumn('skills');
            $table->dropColumn('business_hours_enabled');
            $table->dropColumn('device_token');
            $table->dropColumn('isNotificationAllowed');
        });
    }
};
