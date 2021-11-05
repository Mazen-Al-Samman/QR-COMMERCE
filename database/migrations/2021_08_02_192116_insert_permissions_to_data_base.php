<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertPermissionsToDataBase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $controllers = [
            'admin',
            'admin-vendor',
            'category',
            'feedback',
            'home',
            'invoice',
            'invoice-product',
            'permission',
            'product',
            'role',
            'role-permission',
            'vendor'
        ];

        $actions = [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy'
        ];

        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        DB::statement("TRUNCATE TABLE role_permissions;");
        DB::statement("TRUNCATE TABLE permissions;");
        foreach ($controllers as $controller) {
            foreach ($actions as $action) {
                $permission = "{$controller}.{$action}";
                $description = "This permission will allow the user to {$action} a {$controller}";
                echo "{$description}\n";
                DB::insert('insert into permissions (`permission`, `description`, `created_at`, `updated_at`) values (?, ?, ?, ?)', [$permission, $description, date('Y-m-d h:i:s'), date('Y-m-d h:i:s')]);
            }
        }
        $additional_fields = [
            'invoice.addToCart', 'invoice.deleteFromCart', 'invoice.updateCart', 'admin.dashboard', 'admin-vendor.dashboard', 'role-permission.manage', 'profile.show', 'profile.update', 'product_image.destroy', 'invoice.pdf', 'no-permissions.index'
        ];

        foreach ($additional_fields as $additional_field) {
            DB::insert('insert into permissions (`permission`, `description`, `created_at`, `updated_at`) values (?, ?, ?, ?)', [$additional_field, "Additional Permission", date('Y-m-d h:i:s'), date('Y-m-d h:i:s')]);
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
        DB::statement("TRUNCATE TABLE permissions;");
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }
}
