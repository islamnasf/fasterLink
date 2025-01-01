<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currencies')->insert([
            [
                'country' => 'Egypt',
                'code' => 'EGP',
                'name' => 'Egyptian Pound',
                'symbol' => '£',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country' => 'Saudi Arabia',
                'code' => 'SAR',
                'name' => 'Saudi Riyal',
                'symbol' => '﷼',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
