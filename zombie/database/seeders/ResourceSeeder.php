<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('resources')->insert([
            'type' => 'health',
            'quantity' => 1000,
        ]);
        DB::table('resources')->insert([
            'type' => 'food',
            'quantity' => 5000,
        ]);
        DB::table('resources')->insert([
            'type' => 'weapon',
            'quantity' => 500,
        ]);
    }
}
