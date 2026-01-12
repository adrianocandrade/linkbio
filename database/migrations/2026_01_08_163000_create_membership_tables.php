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
        // 1. Memberships (Planos)
        if (!Schema::hasTable('memberships')) {
            Schema::create('memberships', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('workspace_id')->index();
                $table->unsignedBigInteger('user_id')->index();
                
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2);
                $table->enum('billing_cycle', ['monthly', 'yearly', 'lifetime']);
                
                $table->json('permissions')->nullable();
                $table->json('limits')->nullable();
                
                $table->enum('status', ['active', 'inactive'])->default('active');
                
                $table->timestamps();
            });
        }

        // 2. Membership Subscriptions (Assinaturas dos Contatos)
        if (!Schema::hasTable('membership_subscriptions')) {
            Schema::create('membership_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('membership_id')->index();
                $table->unsignedBigInteger('contact_id')->index();
                $table->unsignedBigInteger('workspace_id')->index();
                
                $table->timestamp('started_at');
                $table->timestamp('expires_at')->nullable();
                $table->timestamp('cancelled_at')->nullable();
                
                $table->enum('payment_status', ['active', 'pending', 'cancelled', 'expired'])->default('pending');
                $table->timestamp('last_payment_at')->nullable();
                $table->timestamp('next_payment_at')->nullable();
                
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
        Schema::dropIfExists('membership_subscriptions');
        Schema::dropIfExists('memberships');
    }
};
