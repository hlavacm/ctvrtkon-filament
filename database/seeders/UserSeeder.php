<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            "name" => "Test Admin",
            "email" => "admin@filament.test",
            "email_verified_at" => now(),
            "password" => Hash::make(UserFactory::TEST_PASSWORD),
            "remember_token" => Str::random(10),
            "role" => RoleEnum::ADMIN->value,
        ]);

        User::factory()
            ->times(20)
            ->referenced()
            ->create();
    }
}
