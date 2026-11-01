<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Moch Diki Widianto', 'email' => 'diki.widianto@unilam.ac.id', 'password' => 'password'],
            ['name' => 'Salman', 'email' => 'salman@unilam.ac.id', 'password' => 'password'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
