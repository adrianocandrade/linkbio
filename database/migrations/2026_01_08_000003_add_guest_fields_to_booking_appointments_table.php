<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestFieldsToBookingAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('booking_appointments')) {
            Schema::table('booking_appointments', function (Blueprint $table) {
                // Adicionar no final da tabela
                $table->unsignedBigInteger('guest_contact_id')->nullable();
                $table->string('guest_name')->nullable();
                $table->string('guest_email')->nullable();
                $table->string('guest_phone', 50)->nullable();
                
                $table->index('guest_contact_id');
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
        if (Schema::hasTable('booking_appointments')) {
            Schema::table('booking_appointments', function (Blueprint $table) {
                $table->dropIndex(['guest_contact_id']);
                $table->dropColumn(['guest_contact_id', 'guest_name', 'guest_email', 'guest_phone']);
            });
        }
    }
}
