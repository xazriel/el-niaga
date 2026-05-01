<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Cek satu per satu sebelum menambah kolom
            if (!Schema::hasColumn('orders', 'receiver_city')) {
                $table->string('receiver_city')->after('receiver_address')->nullable();
            }
            
            if (!Schema::hasColumn('orders', 'receiver_zip')) {
                $table->string('receiver_zip', 10)->after('receiver_city')->nullable();
            }

            if (!Schema::hasColumn('orders', 'service_code')) {
                $table->string('service_code', 20)->after('courier_name')->nullable();
            }
            
            // Untuk tracking_number, kita pastikan dia bisa menerima NULL dan string
            $table->string('tracking_number')->nullable()->change(); 
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['receiver_city', 'receiver_zip', 'service_code']);
        });
    }
};