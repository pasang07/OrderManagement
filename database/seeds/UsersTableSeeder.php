<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
             // array(
                //     'name'=> 'Developer',
                //     'email'=> 'developer@gmail.com',
                //     'password'=> bcrypt('devel0per'),
                //     'username'=> 'developer',
                //     'status'=> 'active',
                //     'role'=>'superadmin',
                //     'image'=> 'avatar.jpg',
                //     'is_new' => 'no',
                //     'is_verified' => 1,
                //     'created_at'=> \Carbon\Carbon::now(),
                //     'updated_at'=> \Carbon\Carbon::now()
                // ),
            array(
                'name'=> 'SuperAdmin',
                'email'=> 'superadmin@gmail.com',
                'password'=> bcrypt('password'),
                'username'=> 'superadmin',
                'status'=> 'active',
                'role'=>'admin',
                'image'=> '1623762339.jpg',
                'is_new' => 'no',
                'is_verified' => 1,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now()
            ),
            array(
                'name'=> 'Demo Admin',
                'email'=> 'demo@gmail.com',
                'password'=> bcrypt('password'),
                'username'=> 'demo_admin',
                'status'=> 'active',
                'role'=>'demo',
                'image'=> null,
                'is_new' => 'no',
                'is_verified' => 1,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now()
            ),
            array(
                'name'=> 'Demo Customer',
                'email'=> 'demo@customer.com',
                'password'=> bcrypt('password'),
                'username'=> 'demo_customer',
                'status'=> 'active',
                'role'=>'others',
                'image'=> null,
                'is_new' => 'no',
                'is_verified' => 1,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now()
            ),
            array(
                'name'=> 'Demo Agent',
                'email'=> 'demo@agent.com',
                'password'=> bcrypt('password'),
                'username'=> 'demo_agent',
                'status'=> 'active',
                'role'=>'agent',
                'image'=> null,
                'is_new' => 'no',
                'is_verified' => 1,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now()
            )
            ];
        \Illuminate\Support\Facades\DB::table('users')->insert($users);
    }
}
