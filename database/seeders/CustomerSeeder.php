<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Customer::create([
                'name' => 'Customer ' . $i,
                'phone' => '08' . rand(1000000000, 9999999999),
                'points' => rand(0, 100),
            ]);
        }
    }
}
