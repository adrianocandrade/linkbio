<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add workspace_id to courses
        if (Schema::hasTable('courses') && !Schema::hasColumn('courses', 'workspace_id')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            // Migrate existing data to default workspace
            DB::statement("
                UPDATE courses c
                JOIN workspaces w ON c.user = w.user_id AND w.is_default = 1
                SET c.workspace_id = w.id
                WHERE c.workspace_id IS NULL
            ");
            
            // Make workspace_id NOT NULL after migration
            Schema::table('courses', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }

        // Add workspace_id to course_lessons
        if (Schema::hasTable('course_lessons') && !Schema::hasColumn('course_lessons', 'workspace_id')) {
            Schema::table('course_lessons', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            DB::statement("
                UPDATE course_lessons cl
                JOIN workspaces w ON cl.user = w.user_id AND w.is_default = 1
                SET cl.workspace_id = w.id
                WHERE cl.workspace_id IS NULL
            ");
            
            Schema::table('course_lessons', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }

        // Add workspace_id to course_enrollments
        if (Schema::hasTable('course_enrollments') && !Schema::hasColumn('course_enrollments', 'workspace_id')) {
            Schema::table('course_enrollments', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            DB::statement("
                UPDATE course_enrollments ce
                JOIN workspaces w ON ce.user = w.user_id AND w.is_default = 1
                SET ce.workspace_id = w.id
                WHERE ce.workspace_id IS NULL
            ");
            
            Schema::table('course_enrollments', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }

        // Add workspace_id to course_sections (if exists)
        if (Schema::hasTable('course_sections') && !Schema::hasColumn('course_sections', 'workspace_id')) {
            Schema::table('course_sections', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable()->after('user');
                $table->index('workspace_id');
            });
            
            DB::statement("
                UPDATE course_sections cs
                JOIN workspaces w ON cs.user = w.user_id AND w.is_default = 1
                SET cs.workspace_id = w.id
                WHERE cs.workspace_id IS NULL
            ");
            
            Schema::table('course_sections', function (Blueprint $table) {
                $table->unsignedBigInteger('workspace_id')->nullable(false)->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('courses', 'workspace_id')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasColumn('course_lessons', 'workspace_id')) {
            Schema::table('course_lessons', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasColumn('course_enrollments', 'workspace_id')) {
            Schema::table('course_enrollments', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }

        if (Schema::hasColumn('course_sections', 'workspace_id')) {
            Schema::table('course_sections', function (Blueprint $table) {
                $table->dropIndex(['workspace_id']);
                $table->dropColumn('workspace_id');
            });
        }
    }
};
