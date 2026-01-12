<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add workspace_id to products
        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'workspace_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            // Migrate existing data to default workspace
            DB::statement("
                UPDATE products p
                JOIN workspaces w ON p.user = w.user_id AND w.is_default = 1
                SET p.workspace_id = w.id
                WHERE p.workspace_id IS NULL
            ");
            
            // Make workspace_id NOT NULL after migration
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }

        // Add workspace_id to shop_categories
        if (Schema::hasTable('shop_categories') && !Schema::hasColumn('shop_categories', 'workspace_id')) {
            Schema::table('shop_categories', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            DB::statement("
                UPDATE shop_categories c
                JOIN workspaces w ON c.user = w.user_id AND w.is_default = 1
                SET c.workspace_id = w.id
                WHERE c.workspace_id IS NULL
            ");
            
            Schema::table('shop_categories', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }

        // Add workspace_id to shop_orders
        if (Schema::hasTable('shop_orders') && !Schema::hasColumn('shop_orders', 'workspace_id')) {
            Schema::table('shop_orders', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            DB::statement("
                UPDATE shop_orders o
                JOIN workspaces w ON o.user = w.user_id AND w.is_default = 1
                SET o.workspace_id = w.id
                WHERE o.workspace_id IS NULL
            ");
            
            Schema::table('shop_orders', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }

        // Add workspace_id to shop_product_options
        if (Schema::hasTable('shop_product_options') && !Schema::hasColumn('shop_product_options', 'workspace_id')) {
            Schema::table('shop_product_options', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            DB::statement("
                UPDATE shop_product_options po
                JOIN workspaces w ON po.user = w.user_id AND w.is_default = 1
                SET po.workspace_id = w.id
                WHERE po.workspace_id IS NULL
            ");
            
            Schema::table('shop_product_options', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }

        // Add workspace_id to shop_product_reviews
        if (Schema::hasTable('shop_product_reviews') && !Schema::hasColumn('shop_product_reviews', 'workspace_id')) {
            Schema::table('shop_product_reviews', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            DB::statement("
                UPDATE shop_product_reviews pr
                JOIN workspaces w ON pr.user = w.user_id AND w.is_default = 1
                SET pr.workspace_id = w.id
                WHERE pr.workspace_id IS NULL
            ");
            
            Schema::table('shop_product_reviews', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('shop_products', 'workspace_id')) {
            Schema::table('shop_products', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasColumn('shop_categories', 'workspace_id')) {
            Schema::table('shop_categories', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasColumn('shop_orders', 'workspace_id')) {
            Schema::table('shop_orders', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasColumn('shop_product_options', 'workspace_id')) {
            Schema::table('shop_product_options', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasColumn('shop_product_reviews', 'workspace_id')) {
            Schema::table('shop_product_reviews', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }
    }
};
