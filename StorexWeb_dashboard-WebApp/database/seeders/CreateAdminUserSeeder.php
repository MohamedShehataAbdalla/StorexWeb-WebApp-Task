<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $user = User::create([
            'name' => 'Storex Web Admin',
            'email' => 'admin@system.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => bcrypt('123456'),
        ]);

    }
}
