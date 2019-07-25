<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            'responsavel-list',
            'responsavel-create',
            'responsavel-edit',
            'responsavel-delete',

            'baixinho-list',
            'baixinho-create',
            'baixinho-edit',
            'baixinho-delete',

            'canal-list',
            'canal-create',
            'canal-edit',
            'canal-delete',
         ];



         foreach ($permissions as $permission) {

              Permission::create(['name' => $permission]);

         }
    }
}
