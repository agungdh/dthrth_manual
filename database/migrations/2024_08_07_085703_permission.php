<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $operator = Role::create(['name' => 'operator']);

        $permissions = [
            Permission::create(['name' => 'create user']),
            Permission::create(['name' => 'read user']),
            Permission::create(['name' => 'update user']),
            Permission::create(['name' => 'delete user']),
        ];

        $admin->givePermissionTo($permissions);

        $permissions = [
            Permission::create(['name' => 'read dthrth']),
            Permission::create(['name' => 'update dthrth']),
        ];

        $admin->givePermissionTo($permissions);
        $operator->givePermissionTo($permissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        exit('NOT REVERSABLE!!!');
    }
};
