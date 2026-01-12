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
        if (!Schema::hasTable('audience_contacts')) {
            Schema::create('audience_contacts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('workspace_id');
                $table->unsignedBigInteger('user_id')->comment('Dono do workspace');
                
                // Dados do Contato
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('phone', 50)->nullable();
                $table->string('avatar')->nullable();
                
                // Origem
                $table->string('source', 50)->comment('booking, tipjar, shop, etc');
                $table->unsignedBigInteger('source_id')->nullable()->comment('ID do registro original');
                
                // Metadata
                $table->json('metadata')->nullable();
                $table->json('tags')->nullable();
                
                // Analytics
                $table->integer('total_interactions')->default(0);
                $table->decimal('total_spent', 10, 2)->default(0);
                $table->timestamp('last_interaction_at')->nullable();
                
                // Status
                $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
                $table->boolean('subscribed_newsletter')->default(false);
                
                $table->timestamps();
                
                $table->unique(['email', 'workspace_id'], 'unique_email_workspace');
                $table->index('workspace_id');
                $table->index('user_id');
                $table->index('source');
                $table->index('status');
            });
        }

        if (!Schema::hasTable('audience_interactions')) {
            Schema::create('audience_interactions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('contact_id');
                $table->unsignedBigInteger('workspace_id');
                
                // Tipo de Interação
                $table->string('type', 50)->comment('booking, purchase, tip, message, etc');
                $table->string('action', 100)->comment('created, updated, cancelled, etc');
                
                // Dados
                $table->decimal('amount', 10, 2)->default(0);
                $table->json('metadata')->nullable();
                
                $table->timestamp('created_at')->useCurrent();
                
                $table->index('contact_id');
                $table->index('workspace_id');
                $table->index('type');
                $table->index('created_at');
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
        Schema::dropIfExists('audience_interactions');
        Schema::dropIfExists('audience_contacts');
    }
};
