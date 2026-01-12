<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Booking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('booking_appointments')) {
            Schema::create('booking_appointments', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('payee_user_id')->nullable();
                $table->longText('service_ids')->nullable();
                $table->date('date')->nullable();
                $table->string('time')->nullable();
                $table->longText('settings')->nullable();
                $table->longText('info')->nullable();
                $table->integer('appointment_status')->default(0);
                $table->float('price', 16, 2)->nullable();
                $table->integer('is_paid')->default(0);
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('booking_working_breaks')) {
            Schema::create('booking_working_breaks', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->date('date')->nullable();
                $table->string('time')->nullable();
                $table->longText('settings')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('booking_services')) {
            Schema::create('booking_services', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('name')->nullable();
                $table->longText('thumbnail')->nullable();
                $table->float('price', 16, 2)->default(0);
                $table->integer('duration')->nullable();
                $table->longText('settings')->nullable();
                $table->integer('status')->default(1);
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('booking_orders')) {
            Schema::create('booking_orders', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('payee_user_id')->nullable();
                $table->integer('appointment_id')->nullable();
                $table->string('method')->nullable();
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

        if (!Schema::hasTable('booking_reviews')) {
            Schema::create('booking_reviews', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('reviewer_id')->nullable();
                $table->string('rating')->nullable();
                $table->longText('review')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('booking_appointments');
        Schema::dropIfExists('booking_services');
        Schema::dropIfExists('booking_reviews');
        Schema::dropIfExists('booking_orders');
    }
}
