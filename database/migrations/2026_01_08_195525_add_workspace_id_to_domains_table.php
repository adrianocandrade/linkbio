<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add workspace_id to domains
        if (Schema::hasTable('domains') && !Schema::hasColumn('domains', 'workspace_id')) {
            Schema::table('domains', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            // Migrate existing data to default workspace
            DB::statement("
                UPDATE domains d
                JOIN workspaces w ON d.user = w.user_id AND w.is_default = 1
                SET d.workspace_id = w.id
                WHERE d.workspace_id IS NULL
            ");
            
            // Make workspace_id NOT NULL after migration
            Schema::table('domains', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('domains', 'workspace_id')) {
            Schema::table('domains', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }
    }
};
