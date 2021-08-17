<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddBasicRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $basic_roles = [
            'Super Admin',
            'Admin',
        ];

        $permissions = [
            'Super Admin' => [
                [
                'controller' => 'admin',
                'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'dashboard'],
                ],
                [
                    'controller' => 'home',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
                ],
                [
                    'controller' => 'permission',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
                ],
                [
                    'controller' => 'role',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
                ],
                [
                    'controller' => 'role-permission',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'manage'],
                ],
                [
                    'controller' => 'vendor',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
                ],
                [
                    'controller' => 'profile',
                    'actions' => ['show', 'update']
                ],
                [
                    'controller' => 'no-permissions',
                    'actions' => ['index']
                ],
            ],
            'Admin' => [
                [
                    'controller' => 'admin-vendor',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'dashboard'],
                ],
                [
                    'controller' => 'category',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
                ],
                [
                    'controller' => 'invoice',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'addToCart', 'deleteFromCart', 'updateCart', 'pdf'],
                ],
                [
                    'controller' => 'invoice-product',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
                ],
                [
                    'controller' => 'product',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
                ],
                [
                    'controller' => 'profile',
                    'actions' => ['show', 'update']
                ],
                [
                  'controller' => 'product_image',
                  'actions' => ['destroy']
                ],
                [
                    'controller' => 'no-permissions',
                    'actions' => ['index']
                ],
            ]
        ];

        $level = [
            'Super Admin' => 1,
            'Admin' => 2,
        ];

        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        DB::statement("INSERT INTO admins (`username`, `phone`, `email`, `active`, `password`, `role_id`, `created_at`, `updated_at`) VALUES ('Admin', '0787878787', 'admin@mybill.com', 1, '$2y$10\$X7ZvHFvq94.r25NNfqfx2OS3K.Z6WYLX3p3JIHkxA9RaKBg4gak0m' ,1 , '2021-08-08', '2021-08-08');");
        foreach ($permissions as $role => $permission) {
            $id = DB::table('roles')->insertGetId([
                'role_title' => $role,
                'role_description' => "",
                'level' => $level[$role],
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]);
            foreach ($permission as $item) {
                $controller = $item['controller'];
                foreach ($item['actions'] as $action) {
                    $permissionModel = \App\Models\Permission::where(['permission' => "{$controller}.{$action}"])->limit(1)->get();
                    if (!empty($permissionModel[0]->id)) {
                        DB::table('role_permissions')->insertGetId([
                            'role_id' => $id,
                            'permission_id' => $permissionModel[0]->id,
                            'created_at' => date("Y-m-d h:i:s"),
                            'updated_at' => date("Y-m-d h:i:s"),
                        ]);
                    }
                }
            }
        }
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        DB::statement("TRUNCATE TABLE role_permissions");
        DB::statement("TRUNCATE TABLE roles");
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }
}
