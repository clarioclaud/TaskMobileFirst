<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //  \App\Models\User::factory(1)->create();
        $adminRole = Role::create([
            "name" => "admin",
        ]);
        $authorRole = Role::create([
            "name" => "author",
        ]);
        $editorRole = Role::create([
            "name" => "editor",  
        ]);
        $viewerRole = Role::create([
            "name" => "viewer",
        ]);

        $createPermission = Permission::create([
            "name" => "create",
        ]);

        $editPermission = Permission::create([
            "name" => "edit",
        ]);

        $readPermission = Permission::create([
            "name" => "read",
        ]);

        $deletePermission = Permission::create([
            "name" => "delete",
        ]);

        $adminRole->givePermissionTo([$createPermission,$editPermission,$readPermission,$deletePermission]);
        $authorRole->givePermissionTo([$createPermission,$editPermission,$readPermission]);
        $editorRole->givePermissionTo([$editPermission,$readPermission]);
        $viewerRole->givePermissionTo([$readPermission]);
    }
}
