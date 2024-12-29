<?php

namespace Database\Seeders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ordersPerMonth = [
            1 => 10,  // January
            2 => 2,   // February
            3 => 8,   // March
            4 => 12,  // April
            5 => 20,  // May
            6 => 15,  // June
            7 => 5,   // July
            8 => 10,  // August
            9 => 18,  // September
            10 => 10, // October
            11 => 6,  // November
            12 => 4,  // December
        ];

        foreach ($ordersPerMonth as $month => $count) {
            for ($i = 0; $i < $count; $i++) {
                Order::factory()->create([
                    'created_at' => now()->setDate(2024, $month, rand(1, 28)), // Random day in the month
                    'updated_at' => now()->setDate(2024, $month, rand(1, 28)), // Sync with created_at
                ]);
            }
        }
    }
}
