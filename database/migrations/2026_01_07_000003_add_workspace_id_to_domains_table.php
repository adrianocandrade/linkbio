<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add workspace_id to domains table
        if (Schema::hasTable('domains') && !Schema::hasColumn('domains', 'workspace_id')) {
            Schema::table('domains', function (Blueprint $table) {
                $table->bigInteger('workspace_id')->unsigned()->nullable()->after('user');
                $table->index('workspace_id');
            });
        }
        
        // Also ensure user column exists (for backward compatibility)
        if (Schema::hasTable('domains') && !Schema::hasColumn('domains', 'user')) {
            Schema::table('domains', function (Blueprint $table) {
                $table->integer('user')->nullable()->after('id');
            });
        }

        // Migrate existing domains to workspaces
        // For each domain linked to a user, find their default workspace and link it
        $domains = DB::table('domains')->whereNotNull('user')->whereNull('workspace_id')->get();
        foreach ($domains as $domain) {
            $defaultWorkspace = DB::table('workspaces')
                ->where('user_id', $domain->user)
                ->where('is_default', 1)
                ->first();
            
            if ($defaultWorkspace) {
                DB::table('domains')
                    ->where('id', $domain->id)
                    ->update(['workspace_id' => $defaultWorkspace->id]);
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
        if (Schema::hasTable('domains') && Schema::hasColumn('domains', 'workspace_id')) {
            Schema::table('domains', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }
    }
};

