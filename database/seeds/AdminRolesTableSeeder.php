<?php

use Illuminate\Database\Seeder;

class AdminRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_roles')->delete();
        
        \DB::table('admin_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '超级管理员',
                'slug' => 'administrator',
                'created_at' => '2019-07-29 20:13:51',
                'updated_at' => '2019-07-30 14:24:24',
            ),
        ));
        
        
    }
}