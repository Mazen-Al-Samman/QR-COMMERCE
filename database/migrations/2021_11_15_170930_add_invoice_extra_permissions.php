<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceExtraPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert('insert into permissions (`permission`, `description`, `created_at`, `updated_at`) values (?, ?, ?, ?)', ['invoice.streamPdf', "Additional Permission", date('Y-m-d h:i:s'), date('Y-m-d h:i:s')]);
        
        $permissionModel = \App\Models\Permission::where(['permission' => "invoice.streamPdf"])->limit(1)->get();
        if (!empty($permissionModel[0]->id)) {
            DB::table('role_permissions')->insertGetId([
                'role_id' => 2,
                'permission_id' => $permissionModel[0]->id,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]);
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
