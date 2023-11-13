<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var User $u */
        $u = User::create(
            [
                'name' => 'user',
                'email' => 'user@mail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => '',
            ]
        );
        $u->assignRole(Roles::Administrator->value);

        User::factory()->count(999)->create();
    }
}
