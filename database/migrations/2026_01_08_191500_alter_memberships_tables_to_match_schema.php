<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Alter memberships table
        Schema::table('memberships', function (Blueprint $table) {
            // Change billing_cycle from string to enum
            DB::statement("ALTER TABLE memberships MODIFY COLUMN billing_cycle ENUM('monthly', 'yearly', 'lifetime') NOT NULL");
            
            // Change status from string to enum
            DB::statement("ALTER TABLE memberships MODIFY COLUMN status ENUM('active', 'inactive') NOT NULL DEFAULT 'active'");
            
            // Change user_id from unsignedInteger to unsignedBigInteger
            DB::statement("ALTER TABLE memberships MODIFY COLUMN user_id BIGINT UNSIGNED NOT NULL");
            
            // Add limits column if it doesn't exist
            if (!Schema::hasColumn('memberships', 'limits')) {
                $table->json('limits')->nullable()->after('permissions');
            }
            
            // Remove deleted_at if it exists
            if (Schema::hasColumn('memberships', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });

        // Alter membership_subscriptions table
        Schema::table('membership_subscriptions', function (Blueprint $table) {
            // Change workspace_id from unsignedInteger to unsignedBigInteger
            DB::statement("ALTER TABLE membership_subscriptions MODIFY COLUMN workspace_id BIGINT UNSIGNED NOT NULL");
            
            // Rename status to payment_status and change to enum
            if (Schema::hasColumn('membership_subscriptions', 'status')) {
                DB::statement("ALTER TABLE membership_subscriptions CHANGE COLUMN status payment_status ENUM('active', 'pending', 'cancelled', 'expired') NOT NULL DEFAULT 'pending'");
            }
            
            // Add new timestamp columns if they don't exist
            if (!Schema::hasColumn('membership_subscriptions', 'last_payment_at')) {
                $table->timestamp('last_payment_at')->nullable()->after('cancelled_at');
            }
            if (!Schema::hasColumn('membership_subscriptions', 'next_payment_at')) {
                $table->timestamp('next_payment_at')->nullable()->after('last_payment_at');
            }
            
            // Remove payment_method and payment_id if they exist
            if (Schema::hasColumn('membership_subscriptions', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('membership_subscriptions', 'payment_id')) {
                $table->dropColumn('payment_id');
            }
        });
    }

    public function down()
    {
        // Reverse the changes
        Schema::table('memberships', function (Blueprint $table) {
            DB::statement("ALTER TABLE memberships MODIFY COLUMN billing_cycle VARCHAR(191) NOT NULL");
            DB::statement("ALTER TABLE memberships MODIFY COLUMN status VARCHAR(191) NOT NULL DEFAULT 'active'");
            DB::statement("ALTER TABLE memberships MODIFY COLUMN user_id INT UNSIGNED NOT NULL");
            
            if (Schema::hasColumn('memberships', 'limits')) {
                $table->dropColumn('limits');
            }
            
            $table->softDeletes();
        });

        Schema::table('membership_subscriptions', function (Blueprint $table) {
            DB::statement("ALTER TABLE membership_subscriptions MODIFY COLUMN workspace_id INT UNSIGNED NOT NULL");
            
            if (Schema::hasColumn('membership_subscriptions', 'payment_status')) {
                DB::statement("ALTER TABLE membership_subscriptions CHANGE COLUMN payment_status status VARCHAR(191) NOT NULL DEFAULT 'active'");
            }
            
            if (Schema::hasColumn('membership_subscriptions', 'last_payment_at')) {
                $table->dropColumn('last_payment_at');
            }
            if (Schema::hasColumn('membership_subscriptions', 'next_payment_at')) {
                $table->dropColumn('next_payment_at');
            }
            
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();
        });
    }
};
