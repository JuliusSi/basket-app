<?php

namespace Database\Seeders;

use App\Model\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class UserSeeder
 * @package Database\Seeders
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'username' => config('seeder.user.username'),
                'email' => config('seeder.user.email'),
                'password' => Hash::make(config('seeder.user.password')),
                'email_verified_at' => now(),
                'api_token' => Str::random(60),
                'image_path' => config('seeder.user.image_path'),
            ]
        );
    }
}
