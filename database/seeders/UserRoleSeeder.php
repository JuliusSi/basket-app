<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRoleSeeder
 * @package Database\Seeders
 */
class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('user')->where('email', config('seeder.user.email'))->first();
        $role = DB::table('role')->where('name', config('seeder.role.name'))->first();

        DB::table('user_role')->insert([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);
    }
}
