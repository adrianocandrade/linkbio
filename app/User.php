<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_settings', 'status', 'username', 'google_id', 'facebook_id'
    ];

    protected $appends = ['plan', 'plandue'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'social' => 'array',
        'buttons' => 'object',
        'color' => 'array',
        'seo' => 'array',
        'payments' => 'array',
        'settings' => 'array',
        'background_settings' => 'array',
        'avatar_settings' => 'array',
        'store' => 'array',
        'booking' => 'array',
        'pwa' => 'array',
        'integrations' => 'array'
    ];



    public function scopeApi($query, $api){
        // ✅ Segurança: Hashear token antes de buscar para comparar com hash armazenado
        if (!empty($api)) {
            $hashedApi = hash('sha256', $api);
            return $query->where('api', '=', $hashedApi);
        }
        return $query->where('api', '=', $api);
    }

    public function scopeAdmin($query){
        return $query->where('role', '=', 1);
    }

    public function getPlanAttribute(){
        if (!$plan = \App\Models\PlansUser::where('user_id', $this->id)->first()) {
            return null;
        }
        return $plan->plan_id;
    }


    public function getPlandueAttribute(){
        if (!$plan = \App\Models\PlansUser::where('user_id', $this->id)->first()) {
            return null;
        }
        return plan('plan_due_string', $this->id);
    }


    public function workspaces(){
        return $this->hasMany(\App\Models\Workspace::class);
    }

    public function plan(){
        return $this->hasMany(\App\Models\PlansUser::class);
    }

    public static function deleteUser($id){
        if (!$user = \App\User::find($id)) {
            return false;
        }

        // Get ALl Registered Upload Paths
        $upload = \App\Models\UserUploadPath::where('user', $user->id)->get();
        // Loop the upload paths
        foreach ($upload as $items) {
            // 
            $directory = $items->path;
            $file = basename($directory);
            $directory = dirname($directory);

            if (mediaExists($directory, $file)) {
                \UserStorage::remove($directory, $file);
            }
        }

        // Delete Blocks Section
        \App\Models\Block::where('user', $user->id)->delete();
        // Delete Blocks
        \App\Models\Blockselement::where('user', $user->id)->delete();
        // Delete Element DB
        \App\Models\Elementdb::where('user', $user->id)->delete();
        // Delete Elements 
        \App\Models\Element::where('user', $user->id)->delete();
        // Delete Highlight
        \App\Models\Highlight::where('user', $user->id)->delete();
        // Delete Linker Track
        \App\Models\Linkertrack::where('user', $user->id)->delete();
        // Delete Pixels
        \App\Models\Pixel::where('user', $user->id)->delete();
        // Delete Plan User
        \App\Models\PlansUser::where('user_id', $user->id)->delete();
        // Delete Plan History
        \App\Models\PlansHistory::where('user_id', $user->id)->delete();
        // Delete User Domain
        \App\Models\Domain::where('user', $user->id)->delete();
        // Delete Visitors
        \App\Models\Visitor::where('user', $user->id)->delete();
        // DELETE Auth Activity
        \App\Models\Authactivity::where('user', $user->id)->delete();
        // DELETE Support Conversation
        \App\Models\SupportConversation::where('user', $user->id)->delete();
        // DELETE Support Message
        \App\Models\SupportMessage::where('user_id', $user->id)->delete();

        $user->delete();

        return true;
    }

    public static function getAddToHead($id){
        if (!$user = \App\User::find($id)) {
            return false;
        }




        if (!plan('settings.add_to_head', $user->id)) {
            return false;
        }

        return user('settings.add_to_head', $user->id);
    }

    public static function ordered_social($user_id){
        if (!$user = \App\User::find($user_id)) {
            return [];
        }

        $socials = socials();
        $user_socials = (array) $user->social;


        $array = $socials;

        try {
            $array = array_replace(array_flip(array_keys($user_socials)), $socials);
        } catch (\Exception $e) {
            
        }


        return $array;
    }
}
