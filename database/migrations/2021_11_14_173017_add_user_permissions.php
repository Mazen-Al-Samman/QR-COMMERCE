<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUserPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $controller = "user";
        $actions = [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy'
        ];
        foreach ($actions as $action) {
            $permission = "{$controller}.{$action}";
            $description = "This permission will allow the user to {$action} a {$controller}";
            echo "{$description}\n";
            DB::insert('insert into permissions (`permission`, `description`, `created_at`, `updated_at`) values (?, ?, ?, ?)', [$permission, $description, date('Y-m-d h:i:s'), date('Y-m-d h:i:s')]);
        }

        $permissions = [
            'Super Admin' => [
                [
                    'controller' => 'user',
                    'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
                ]
            ]
        ];

        foreach ($permissions as $role => $permission) {
            foreach ($permission as $item) {
                $controller = $item['controller'];
                foreach ($item['actions'] as $action) {
                    $permissionModel = \App\Models\Permission::where(['permission' => "{$controller}.{$action}"])->limit(1)->get();
                    if (!empty($permissionModel[0]->id)) {
                        DB::table('role_permissions')->insertGetId([
                            'role_id' => 1,
                            'permission_id' => $permissionModel[0]->id,
                            'created_at' => date("Y-m-d h:i:s"),
                            'updated_at' => date("Y-m-d h:i:s"),
                        ]);
                    }
                }
            }
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
