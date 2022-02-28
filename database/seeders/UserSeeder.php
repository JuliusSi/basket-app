<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Model\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class UserSeeder.
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run(): void
    {
        $this->createSystemUser();
        $this->createRandomUsers(random_int(150, 250));
    }

    private function createSystemUser(): void
    {
        User::create(
            [
                'username' => config('seeder.user.username'),
                'email' => config('seeder.user.email'),
                'status' => User::STATUS_ADMINISTRATOR,
                'password' => Hash::make(config('seeder.user.password')),
                'email_verified_at' => now(),
                'api_token' => Str::random(60),
                'image_path' => config('seeder.user.image_path'),
            ]
        );
    }

    private function createRandomUsers(int $count): void
    {
        User::factory()->count($count)->create();
    }
}
