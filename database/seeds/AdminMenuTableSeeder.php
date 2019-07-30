<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => '仪表盘',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-30 14:23:55',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 3,
                'title' => '系统管理',
                'icon' => 'fa-tasks',
                'uri' => NULL,
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-30 14:22:49',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 4,
                'title' => '用户管理',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-30 14:23:03',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 5,
                'title' => '角色管理',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-30 14:23:12',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 6,
                'title' => '权限管理',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-30 14:23:21',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 7,
                'title' => '菜单管理',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-30 14:23:31',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 8,
                'title' => '操作日志',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-30 14:23:41',
            ),
        ));
        
        
    }
}