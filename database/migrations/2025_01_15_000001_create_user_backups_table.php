<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBackupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_backups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('backup_file')->comment('Nome do arquivo JSON do backup');
            $table->string('backup_path')->comment('Caminho completo do arquivo de backup');
            $table->integer('file_size')->nullable()->comment('Tamanho do arquivo em bytes');
            $table->text('backup_metadata')->nullable()->comment('Metadados adicionais em JSON');
            $table->timestamp('backup_date')->useCurrent();
            $table->timestamp('expires_at')->comment('Data de expiração do backup (6 meses)');
            $table->boolean('is_restored')->default(false)->comment('Indica se o backup foi restaurado');
            $table->timestamp('restored_at')->nullable()->comment('Data da restauração');
            $table->unsignedBigInteger('restored_by')->nullable()->comment('ID do admin que restaurou');
            $table->timestamps();

            $table->index('user_id');
            $table->index('email');
            $table->index('username');
            $table->index('backup_date');
            $table->index('expires_at');
            $table->index('is_restored');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_backups');
    }
}

