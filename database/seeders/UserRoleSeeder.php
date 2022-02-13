<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Model\Role;
use App\Model\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', config('seeder.user.email'))->first();
        $roles = Role::all();

        $user->roles()->saveMany($roles);

    }
}
