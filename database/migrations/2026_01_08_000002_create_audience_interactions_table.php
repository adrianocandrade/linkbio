<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudienceInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            
            // Indexes
            $table->index('contact_id');
            $table->index('workspace_id');
            $table->index('type');
            $table->index('created_at');
            
            // Foreign keys
            $table->foreign('contact_id')
                ->references('id')
                ->on('audience_contacts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audience_interactions');
    }
}
