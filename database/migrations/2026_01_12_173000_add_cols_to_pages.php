<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'postedBy')) {
                $table->integer('postedBy')->default(1);
            }
            if (!Schema::hasColumn('pages', 'thumbnail')) {
                $table->string('thumbnail')->nullable();
            }
            if (!Schema::hasColumn('pages', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('pages', 'author')) {
                $table->string('author')->nullable();
            }
            if (!Schema::hasColumn('pages', 'ttr')) {
                $table->string('ttr')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['postedBy', 'thumbnail', 'description', 'author', 'ttr']);
        });
    }
};
