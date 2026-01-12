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
        // Add workspace_id to booking_appointments
        if (Schema::hasTable('booking_appointments') && !Schema::hasColumn('booking_appointments', 'workspace_id')) {
            Schema::table('booking_appointments', function (Blueprint $table) {
                $table->bigInteger('workspace_id')->unsigned()->nullable()->after('user');
                $table->index('workspace_id');
            });
        }

        // Add workspace_id to booking_services
        if (Schema::hasTable('booking_services') && !Schema::hasColumn('booking_services', 'workspace_id')) {
            Schema::table('booking_services', function (Blueprint $table) {
                $table->bigInteger('workspace_id')->unsigned()->nullable()->after('user');
                $table->index('workspace_id');
            });
        }

        // Add workspace_id to booking_working_breaks
        if (Schema::hasTable('booking_working_breaks') && !Schema::hasColumn('booking_working_breaks', 'workspace_id')) {
            Schema::table('booking_working_breaks', function (Blueprint $table) {
                $table->bigInteger('workspace_id')->unsigned()->nullable()->after('user');
                $table->index('workspace_id');
            });
        }

        // Add workspace_id to booking_orders
        if (Schema::hasTable('booking_orders') && !Schema::hasColumn('booking_orders', 'workspace_id')) {
            Schema::table('booking_orders', function (Blueprint $table) {
                $table->bigInteger('workspace_id')->unsigned()->nullable()->after('user');
                $table->index('workspace_id');
            });
        }

        // Add workspace_id to booking_reviews
        if (Schema::hasTable('booking_reviews') && !Schema::hasColumn('booking_reviews', 'workspace_id')) {
            Schema::table('booking_reviews', function (Blueprint $table) {
                $table->bigInteger('workspace_id')->unsigned()->nullable()->after('user');
                $table->index('workspace_id');
            });
        }

        // Backfill existing data - assign to default workspace
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $defaultWorkspace = DB::table('workspaces')
                ->where('user_id', $user->id)
                ->where('is_default', 1)
                ->first();
            
            if (!$defaultWorkspace) {
                $defaultWorkspace = DB::table('workspaces')
                    ->where('user_id', $user->id)
                    ->orderBy('id', 'ASC')
                    ->first();
            }
            
            if ($defaultWorkspace) {
                if (Schema::hasTable('booking_appointments')) {
                    DB::table('booking_appointments')
                        ->where('user', $user->id)
                        ->update(['workspace_id' => $defaultWorkspace->id]);
                }
                
                if (Schema::hasTable('booking_services')) {
                    DB::table('booking_services')
                        ->where('user', $user->id)
                        ->update(['workspace_id' => $defaultWorkspace->id]);
                }
                
                if (Schema::hasTable('booking_working_breaks')) {
                    DB::table('booking_working_breaks')
                        ->where('user', $user->id)
                        ->update(['workspace_id' => $defaultWorkspace->id]);
                }
                
                if (Schema::hasTable('booking_orders')) {
                    DB::table('booking_orders')
                        ->where('user', $user->id)
                        ->update(['workspace_id' => $defaultWorkspace->id]);
                }
                
                if (Schema::hasTable('booking_reviews')) {
                    DB::table('booking_reviews')
                        ->where('user', $user->id)
                        ->update(['workspace_id' => $defaultWorkspace->id]);
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
        if (Schema::hasTable('booking_appointments') && Schema::hasColumn('booking_appointments', 'workspace_id')) {
            Schema::table('booking_appointments', function (Blueprint $table) {
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasTable('booking_services') && Schema::hasColumn('booking_services', 'workspace_id')) {
            Schema::table('booking_services', function (Blueprint $table) {
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasTable('booking_working_breaks') && Schema::hasColumn('booking_working_breaks', 'workspace_id')) {
            Schema::table('booking_working_breaks', function (Blueprint $table) {
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasTable('booking_orders') && Schema::hasColumn('booking_orders', 'workspace_id')) {
            Schema::table('booking_orders', function (Blueprint $table) {
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasTable('booking_reviews') && Schema::hasColumn('booking_reviews', 'workspace_id')) {
            Schema::table('booking_reviews', function (Blueprint $table) {
                $table->dropColumn('workspace_id');
            });
        }
    }
};

