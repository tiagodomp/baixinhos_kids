<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(DB $db)
    {
        $permissions = [

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',

            'funcionario-list',
            'funcionario-create',
            'funcionario-edit',
            'funcionario-delete',

            'cabeleireiro-list',
            'cabeleireiro-create',
            'cabeleireiro-edit',
            'cabeleireiro-delete',

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
