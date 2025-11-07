<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'username' => 'admin',
                'password' => Hash::make('12070701'),
                'full_name' => 'Administrator',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'current_task_status' => 'idle'
            ],
            [
                'username' => 'teamlead1',
                'password' => Hash::make('12070701'),
                'full_name' => 'Team Lead One',
                'email' => 'teamlead1@example.com',
                'role' => 'team_lead',
                'current_task_status' => 'idle'
            ],
            [
                'username' => 'dev1',
                'password' => Hash::make('12070701'),
                'full_name' => 'Developer One',
                'email' => 'dev1@example.com',
                'role' => 'developer',
                'current_task_status' => 'idle'
            ],
            [
                'username' => 'dev2',
                'password' => Hash::make('12070701'),
                'full_name' => 'Developer Two',
                'email' => 'dev2@example.com',
                'role' => 'developer',
                'current_task_status' => 'idle'
            ],
            [
                'username' => 'designer1',
                'password' => Hash::make('12070701'),
                'full_name' => 'Designer One',
                'email' => 'designer1@example.com',
                'role' => 'designer',
                'current_task_status' => 'idle'
            ]
        ];

        DB::table('users')->insert($users);
    }
}
