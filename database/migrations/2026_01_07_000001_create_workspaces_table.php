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
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            // Core Identity
            $table->string('name')->default('My Workspace');
            $table->string('slug')->unique(); // The 'username' part of the URL
            $table->integer('status')->default(1);
            $table->integer('is_default')->default(0);

            // Bio Content
            $table->longText('bio')->nullable();
            $table->string('avatar')->nullable();
            
            // Configuration & Styling
            $table->longText('settings')->nullable();
            $table->longText('background')->nullable();
            $table->longText('background_settings')->nullable();
            $table->longText('buttons')->nullable();
            $table->longText('social')->nullable();
            $table->longText('font')->nullable();
            $table->string('theme')->nullable();
            $table->longText('color')->nullable();
            $table->longText('avatar_settings')->nullable();
            
            // Advanced
            $table->longText('seo')->nullable();
            $table->longText('pwa')->nullable();
            $table->longText('store')->nullable();
            $table->longText('integrations')->nullable();
            $table->longText('booking')->nullable();
            $table->longText('payments')->nullable();
            
            $table->timestamps();
        });

        // Migrate existing users to workspaces
        $users = \App\User::all();
        foreach ($users as $user) {
            DB::table('workspaces')->insert([
                'user_id' => $user->id,
                'name' => $user->name . "'s Page",
                'slug' => $user->username,
                'status' => $user->status,
                'is_default' => 1,
                'bio' => $user->bio,
                'avatar' => $user->avatar,
                'settings' => $user->settings,
                'background' => $user->background,
                'background_settings' => $user->background_settings,
                'buttons' => $user->buttons,
                'social' => $user->social,
                'font' => $user->font,
                'theme' => $user->theme,
                'color' => $user->color,
                'avatar_settings' => $user->avatar_settings,
                'seo' => $user->seo,
                'pwa' => $user->pwa,
                'store' => $user->store,
                'integrations' => $user->integrations,
                'booking' => $user->booking,
                'payments' => $user->payments,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workspaces');
    }
};
