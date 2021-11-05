<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=5;$i++) {
            DB::table('users')->insert([
                'name' => 'user' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => Hash::make('2281337'),
                'role' => 'user'
            ]);
        }

        for ($i=1;$i<=2;$i++) {
            DB::table('users')->insert([
                'name' => 'manager' . $i,
                'email' => 'manager' . $i . '@gmail.com',
                'password' => Hash::make('2281337'),
                'role' => 'manager'
            ]);
        }
    }
}
