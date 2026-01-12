<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->longText('value');
        });
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->string('scheme')->nullable();
            $table->string('host')->nullable();
            $table->string('index_url')->nullable();
            $table->longText('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('status')->default(1);
            $table->string('price')->nullable();
            $table->longText('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('plans_users', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_id');
            $table->integer('user_id');
            $table->dateTime('plan_due')->nullable();
            $table->longText('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('auth_activity', function (Blueprint $table) {
            $table->id();
            $table->integer('user');
            $table->string('type');
            $table->string('message');
            $table->string('ip');
            $table->string('os');
            $table->string('browser');
            $table->timestamps();
        });

        Schema::create('linker', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('slug')->nullable();
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
        //
    }
}
