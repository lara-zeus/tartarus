<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'hj hj',
            'email' => 'hj@hj.hj',
            'password' => Hash::make('hjhjhj'),
        ]);
    }
}
