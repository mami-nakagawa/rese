<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // adminユーザー作成
        $administrator = User::create([
            'name' => '管理者',
            'email' => 'test@admin.com',
            'password' => bcrypt('password'),
            ]);

        $shop_representative = User::create([
            'name' => '店舗代表者',
            'email' => 'test@shop.com',
            'password' => bcrypt('password'),
            ]);

        $user = User::create([
            'name' => '利用者',
            'email' => 'test@user.com',
            'password' => bcrypt('password'),
            ]);

        // Role作成
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);

        // Permission作成
        $registerPermission = Permission::create(['name' => 'register']);
        $createShopPermission = Permission::create(['name' => 'create_shop']);
        $updateShopPermission = Permission::create(['name' => 'update_shop']);
        $readReservationPermission = Permission::create(['name' => 'read_reservation']);

        // RoleとPermissionを関連付け
        $adminRole->givePermissionTo($registerPermission);
        $editorRole->givePermissionTo($createShopPermission);
        $editorRole->givePermissionTo($updateShopPermission);
        $editorRole->givePermissionTo($readReservationPermission);

        // ユーザーに役割を割り当て
        $administrator->assignRole($adminRole);
        $shop_representative->assignRole($editorRole);
    }
}
