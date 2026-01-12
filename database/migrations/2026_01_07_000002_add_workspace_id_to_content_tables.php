<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddWorkspaceIdToContentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add workspace_id to blocks
        if (Schema::hasTable('blocks') && !Schema::hasColumn('blocks', 'workspace_id')) {
            Schema::table('blocks', function (Blueprint $table) {
                $table->bigInteger('workspace_id')->unsigned()->nullable()->after('user');
                $table->index('workspace_id');
            });
        }

        // Add workspace_id to highlights
        if (Schema::hasTable('highlights') && !Schema::hasColumn('highlights', 'workspace_id')) {
            Schema::table('highlights', function (Blueprint $table) {
                $table->bigInteger('workspace_id')->unsigned()->nullable()->after('user');
                $table->index('workspace_id');
            });
        }

        // Add workspace_id to elements
        if (Schema::hasTable('elements') && !Schema::hasColumn('elements', 'workspace_id')) {
            Schema::table('elements', function (Blueprint $table) {
                $table->bigInteger('workspace_id')->unsigned()->nullable()->after('user');
                $table->index('workspace_id');
            });
        }

        // Add workspace_id to visitors (Analytics)
        if (Schema::hasTable('visitors') && !Schema::hasColumn('visitors', 'workspace_id')) {
            Schema::table('visitors', function (Blueprint $table) {
                $table->bigInteger('workspace_id')->unsigned()->nullable()->after('user');
                $table->index('workspace_id');
            });
        }

         // Add workspace_id to product_orders (Shop)
         // Table name might be 'product_orders' or 'sandy_shop_orders' depending on module
         // Checking MixController it calls \Sandy\Blocks\shop\Models\ProductOrder
         // Let's assume standard Laravel table name guessing for now, but safer to check.
         // MixController uses: \Sandy\Blocks\shop\Models\ProductOrder
         // I'll skip product_orders for this specific migration step to avoid guessing wrong table name
         // and focus on the UI components first.

        // Seed existing data
        // For every user, find their default workspace (first one) and assign it to their content.
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            // Find default workspace: created first
            $defaultWorkspace = DB::table('workspaces')->where('user_id', $user->id)->orderBy('id', 'ASC')->first();
            
            if ($defaultWorkspace) {
                DB::table('blocks')->where('user', $user->id)->update(['workspace_id' => $defaultWorkspace->id]);
                DB::table('highlights')->where('user', $user->id)->update(['workspace_id' => $defaultWorkspace->id]);
                DB::table('elements')->where('user', $user->id)->update(['workspace_id' => $defaultWorkspace->id]);
                DB::table('visitors')->where('user', $user->id)->update(['workspace_id' => $defaultWorkspace->id]);
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
        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn('workspace_id');
        });
        Schema::table('highlights', function (Blueprint $table) {
            $table->dropColumn('workspace_id');
        });
        Schema::table('elements', function (Blueprint $table) {
            $table->dropColumn('workspace_id');
        });
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn('workspace_id');
        });
    }
}
