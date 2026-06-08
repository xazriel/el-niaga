<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
        ]);

        // Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@farhana.com'],
            [
                'name' => 'Admin Farhana',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Default Customer User
        User::updateOrCreate(
            ['email' => 'customer@farhana.com'],
            [
                'name' => 'Farhana Customer',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'points' => 120, // Berikan 120 poin awal untuk tes
                'email_verified_at' => now(),
            ]
        );

        // Seed Settings
        \App\Models\Setting::updateOrCreate(['key' => 'loyalty_spend_per_point_rate'], ['value' => '10000']);
        \App\Models\Setting::updateOrCreate(['key' => 'loyalty_point_value_rate'], ['value' => '1000']);
        \App\Models\Setting::updateOrCreate(['key' => 'slow_moving_threshold_days'], ['value' => '30']);
        \App\Models\Setting::updateOrCreate(['key' => 'slow_moving_max_sold'], ['value' => '5']);

        // Seed Vouchers
        \App\Models\Voucher::updateOrCreate(
            ['code' => 'PROMO10K'],
            [
                'type' => 'fixed',
                'value' => 10000,
                'min_spend' => 50000,
                'is_active' => true,
                'expires_at' => now()->addYear(),
                'points_cost' => 0
            ]
        );
        \App\Models\Voucher::updateOrCreate(
            ['code' => 'LOYAL50'],
            [
                'type' => 'fixed',
                'value' => 50000,
                'min_spend' => 150000,
                'is_active' => true,
                'expires_at' => now()->addYear(),
                'points_cost' => 50 // Bisa ditukar dengan 50 poin
            ]
        );

        // Seed Articles
        \App\Models\Article::updateOrCreate(
            ['slug' => 'tips-memilih-busana-muslim'],
            [
                'title' => 'Tips Memilih Busana Muslim yang Nyaman untuk Sehari-hari',
                'content' => 'Busana muslim yang nyaman sangat penting untuk menunjang aktivitas sehari-hari. Pilihlah bahan katun atau rayon yang menyerap keringat. Hindari pakaian yang terlalu ketat dan utamakan potongan longgar (oversized) yang tetap syar\'i namun modis.',
                'image' => null,
                'is_published' => true,
                'published_at' => now()
            ]
        );
        \App\Models\Article::updateOrCreate(
            ['slug' => 'trend-hijab-gamis-minimalis-2026'],
            [
                'title' => 'Trend Hijab dan Gamis Minimalis Modern di Tahun 2026',
                'content' => 'Tahun 2026 menghadirkan tren modesty fashion yang mengarah ke konsep minimalis modern dengan warna bumi (earthy tones) seperti olive, beige, dan cokelat tanah. Desain yang simpel tanpa banyak payet justru memberikan kesan mewah dan elegan.',
                'image' => null,
                'is_published' => true,
                'published_at' => now()
            ]
        );
    }
}
