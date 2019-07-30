<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_users')->delete();
        
        \DB::table('admin_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$ouajkdeyoHwaDr00sJrciOe4mU0YOopISanjL8zWBymtO2VAHflEi',
                'name' => '超级管理员',
                'avatar' => NULL,
                'remember_token' => 'u9OYi8Mh2paNsswhYKVNsiZu3g01B4nipjFMIj8ZwytSLOhlkLTc10B5Plpq',
                'created_at' => '2019-07-29 20:13:50',
                'updated_at' => '2019-07-30 14:24:57',
            ),
        ));
        
        
    }
}