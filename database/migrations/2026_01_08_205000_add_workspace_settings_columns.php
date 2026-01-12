<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add api column to workspaces if it doesn't exist
        if (Schema::hasTable('workspaces') && !Schema::hasColumn('workspaces', 'api')) {
            Schema::table('workspaces', function (Blueprint $table) {
                $table->text('api')->nullable()->after('integrations');
            });
            
            // Migrate existing API keys from users to their default workspace
            DB::statement("
                UPDATE workspaces w
                JOIN users u ON w.user_id = u.id AND w.is_default = 1
                SET w.api = u.api
                WHERE w.api IS NULL AND u.api IS NOT NULL
            ");
        }

        // Add workspace_id to pixels table if it doesn't exist
        if (Schema::hasTable('pixels') && !Schema::hasColumn('pixels', 'workspace_id')) {
            Schema::table('pixels', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            // Migrate existing pixels to default workspace
            DB::statement("
                UPDATE pixels p
                JOIN workspaces w ON p.user = w.user_id AND w.is_default = 1
                SET p.workspace_id = w.id
                WHERE p.workspace_id IS NULL
            ");
            
            // Make workspace_id NOT NULL after migration
            Schema::table('pixels', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('workspaces', 'api')) {
            Schema::table('workspaces', function (Blueprint $table) {
                $table->dropColumn('api');
            });
        }

        if (Schema::hasColumn('pixels', 'workspace_id')) {
            Schema::table('pixels', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }
    }
};
