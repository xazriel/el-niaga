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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('points_earned')->default(0)->after('grand_total');
            $table->integer('points_redeemed')->default(0)->after('points_earned');
            $table->decimal('points_discount', 12, 2)->default(0)->after('points_redeemed');
            $table->string('voucher_code')->nullable()->after('points_discount');
            $table->decimal('voucher_discount', 12, 2)->default(0)->after('voucher_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['points_earned', 'points_redeemed', 'points_discount', 'voucher_code', 'voucher_discount']);
        });
    }
};
