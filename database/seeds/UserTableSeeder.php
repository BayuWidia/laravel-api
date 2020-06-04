<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Bayu Widia Santoso',
            'email' => 'bayu@gmail.com',
            'password' => bcrypt('qwe'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Rendynal Mester',
            'email' => 'rendynal@gmail.com',
            'password' => bcrypt('qwe'),
            'role' => 'developer'
        ]);

        User::create([
            'name' => 'Bona Rizky',
            'email' => 'bona@gmail.com',
            'password' => bcrypt('qwe'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Yugas',
            'email' => 'yugas@gmail.com',
            'password' => bcrypt('qwe'),
            'role' => 'user'
        ]);
    }
}
