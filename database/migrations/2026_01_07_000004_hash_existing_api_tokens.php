<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ✅ Segurança: Hashear tokens API existentes
        // Tokens SHA256 têm 64 caracteres, tokens plain geralmente têm menos
        $users = DB::table('users')
            ->whereNotNull('api')
            ->where('api', '!=', '')
            ->whereRaw('LENGTH(api) < 64')  // Apenas tokens que ainda não foram hasheados
            ->get();

        foreach ($users as $user) {
            if (!empty($user->api)) {
                $hashed = hash('sha256', $user->api);
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['api' => $hashed]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Não é possível reverter o hash sem conhecer os tokens originais
        // Esta migration é irreversível por design de segurança
    }
};

