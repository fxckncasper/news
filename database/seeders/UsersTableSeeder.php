<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [ //admin
                'name'      => 'test',
                'username'  => 'test',
                'email'     => 'test@mail.com',
                'password'  => Hash::make('admin'),
                'role'      => 'admin',
                'status'    => 'active',
            ],
            [ //user
                'name'      => 'user',
                'username'  => 'user',
                'email'     => 'user@mail.com',
                'password'  => Hash::make('user'),
                'role'      => 'user',
                'status'    => 'active',
            ],
        ]);
    }
}
