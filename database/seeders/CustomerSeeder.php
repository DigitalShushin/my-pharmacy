<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            'name' => 'Counter Sale',
            'phone' => '9841',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
