<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new = new User();

        $new->name = 'youssef';
        $new->email = 'admin@admin.com';
        $new->password = \Hash::make(123456);

        $new->save();

    }
}
