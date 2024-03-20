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
            'name' => 'base',
            'email' => 'base@base.base',
            'password' => Hash::make('basebasebase'),
        ]);
    }
}
