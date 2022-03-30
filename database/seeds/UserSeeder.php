<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Linda';
        $user->email = 'linda@htmail.it';
        $user->password = bcrypt('password');
        $user->save();
    }
}
