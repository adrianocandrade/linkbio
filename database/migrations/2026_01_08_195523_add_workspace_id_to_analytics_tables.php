<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add workspace_id to visitors
        if (Schema::hasTable('visitors') && !Schema::hasColumn('visitors', 'workspace_id')) {
            Schema::table('visitors', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            // Migrate existing data to default workspace
            DB::statement("
                UPDATE visitors v
                JOIN workspaces w ON v.user = w.user_id AND w.is_default = 1
                SET v.workspace_id = w.id
                WHERE v.workspace_id IS NULL
            ");
            
            Schema::table('visitors', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }

        // Add workspace_id to linkertrack
        if (Schema::hasTable('linkertrack') && !Schema::hasColumn('linkertrack', 'workspace_id')) {
            Schema::table('linkertrack', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            DB::statement("
                UPDATE linkertrack lt
                JOIN workspaces w ON lt.user = w.user_id AND w.is_default = 1
                SET lt.workspace_id = w.id
                WHERE lt.workspace_id IS NULL
            ");
            
            Schema::table('linkertrack', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }

        // Add workspace_id to my_sessions
        if (Schema::hasTable('my_sessions') && !Schema::hasColumn('my_sessions', 'workspace_id')) {
            Schema::table('my_sessions', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            DB::statement("
                UPDATE my_sessions ms
                JOIN workspaces w ON ms.user = w.user_id AND w.is_default = 1
                SET ms.workspace_id = w.id
                WHERE ms.workspace_id IS NULL
            ");
            
            Schema::table('my_sessions', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('visitors', 'workspace_id')) {
            Schema::table('visitors', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasColumn('linkertrack', 'workspace_id')) {
            Schema::table('linkertrack', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasColumn('my_sessions', 'workspace_id')) {
            Schema::table('my_sessions', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }
    }
};
