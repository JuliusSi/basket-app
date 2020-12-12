<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        DB::table('user')->insert([
            'username' => config('seeder.user.username'),
            'email' => config('seeder.user.email'),
            'password' => Hash::make(config('seeder.user.password')),
            'email_verified_at' => now(),
        ]);
    }
}
