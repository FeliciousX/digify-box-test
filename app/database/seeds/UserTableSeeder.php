<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        $users = array(
            array(
                'login'     => 'love@example.com',
                'password'  => Hash::make('feliciousx'),
                'name'      => 'Debbie Tan'
            )
        );

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
