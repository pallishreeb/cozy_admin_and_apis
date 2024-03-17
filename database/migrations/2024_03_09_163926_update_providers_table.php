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
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('otp_valid_until')->nullable();
            $table->unsignedBigInteger('category_id')->nullable()->after('email_verified_at');
            $table->unsignedBigInteger('service_id')->nullable()->after('category_id');
            $table->boolean('isAdmin')->default(false)->after('service_id');
            // Add foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
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
            // Drop the foreign key constraints
            $table->dropForeign(['category_id']);
            $table->dropForeign(['service_id']);
            $table->dropColumn('email_verified_at');
            $table->dropColumn('otp_valid_until');
            $table->dropColumn('isAdmin');
            // Drop the new columns
            $table->dropColumn(['category_id', 'service_id']);
        });
    }
};
