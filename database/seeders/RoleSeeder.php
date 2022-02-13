<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Model\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert(config('seeder.roles'));
    }
}
