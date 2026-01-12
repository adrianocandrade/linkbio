<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudienceContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            $table->json('metadata')->nullable()->comment('Dados adicionais específicos da origem');
            $table->json('tags')->nullable()->comment('Tags para segmentação');
            
            // Analytics
            $table->integer('total_interactions')->default(0);
            $table->decimal('total_spent', 10, 2)->default(0);
            $table->timestamp('last_interaction_at')->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
            $table->boolean('subscribed_newsletter')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->unique(['email', 'workspace_id']);
            $table->index('workspace_id');
            $table->index('user_id');
            $table->index('source');
            $table->index('status');
            $table->index('last_interaction_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audience_contacts');
    }
}
