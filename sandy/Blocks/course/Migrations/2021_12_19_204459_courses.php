<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Courses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('courses')) {
            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('name')->nullable();
                $table->integer('status')->default(1);
                $table->integer('price_type')->default(1);
                $table->float('price', 16, 2)->nullable();
                $table->longText('price_pwyw')->nullable();
                $table->string('compare_price')->nullable();
                $table->string('course_level')->nullable();
                $table->longText('settings')->nullable();
                $table->longText('course_includes')->nullable();
                $table->string('course_duration')->nullable();
                $table->integer('course_expiry_type')->default(1);
                $table->string('course_expiry')->nullable();
                $table->longText('tags')->nullable();
                $table->longText('banner')->nullable();
                $table->longText('description')->nullable();
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('courses_lesson')) {
            Schema::create('courses_lesson', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('course_id')->nullable();
                $table->string('name')->nullable();
                $table->longText('description')->nullable();
                $table->string('lesson_type')->default(0);
                $table->integer('status')->default(1);
                $table->string('lesson_duration')->nullable();
                $table->longText('lesson_data')->nullable();
                $table->longText('settings')->nullable();
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('courses_reviews')) {
            Schema::create('courses_reviews', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('reviewer_id')->nullable();
                $table->integer('course_id')->nullable();
                $table->string('rating')->nullable();
                $table->longText('review')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('courses_enrollments')) {
            Schema::create('courses_enrollments', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('payee_user_id')->nullable();
                $table->integer('course_id')->nullable();
                $table->longText('lesson_taken')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('courses_order')) {
            Schema::create('courses_order', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('payee_user_id')->nullable();
                $table->integer('course_id')->nullable();
                $table->longText('details')->nullable();
                $table->string('currency')->nullable();
                $table->string('email')->nullable();
                $table->string('ref')->nullable();
                $table->float('price', 16, 2)->nullable();
                $table->longText('extra')->nullable();
                $table->integer('status')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
        Schema::dropIfExists('courses_lesson');
        Schema::dropIfExists('courses_reviews');
        Schema::dropIfExists('courses_enrollments');
        Schema::dropIfExists('courses_order');
    }
}
