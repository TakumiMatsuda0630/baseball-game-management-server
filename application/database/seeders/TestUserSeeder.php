<?php

declare(strict_types=1);

namespace Database\Seeders;

use Application\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'test@test.com',
            ],
            [
                'name' => 'test user',
                'password' => Hash::make('password1234'),
            ]
        );
    }
}
