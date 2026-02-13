<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $teams = config('permission.teams');
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if ($teams && !empty($tableNames)) {
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($columnNames) {
                $table->uuid($columnNames['team_foreign_key'])->nullable()->after('permission_id');
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');
            });

            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($columnNames) {
                $table->uuid($columnNames['team_foreign_key'])->nullable()->after('role_id');
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');
            });

            Schema::table($tableNames['roles'], function (Blueprint $table) use ($columnNames) {
            $table->uuid($columnNames['team_foreign_key'])->nullable()->after('guard_name');
            $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
        });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permission_tables', function (Blueprint $table) {
            //
        });
    }
};
