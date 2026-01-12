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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('postedBy')->default(1);
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('location')->nullable(); // Used in footer query
            $table->string('type')->default('internal');
            $table->integer('status')->default(1);
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->string('author')->nullable();
            $table->string('ttr')->nullable();
            $table->text('settings')->nullable();
            $table->integer('order')->default(0);
            $table->integer('total_views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
