<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        $users = array(
            array(
                'username'  => 'feliciousx',
                'password'  => Hash::make('feliciousx'),
                'email'     => 'feliciousx@gmail.com'
            )
        );

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
