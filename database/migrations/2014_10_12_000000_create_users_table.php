<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->longText('bio')->nullable();
            $table->longText('social')->nullable();
            $table->longText('background')->nullable();
            $table->longText('buttons')->nullable();
            $table->longText('settings')->nullable();
            $table->integer('role')->default(0);
            $table->string('avatar')->nullable();
            $table->string('emailToken')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('status')->default(1);
            $table->integer('hasTrial')->default(0);
            $table->string('lastActivity')->nullable();
            $table->string('lastAgent')->nullable();
            $table->longText('extra')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
