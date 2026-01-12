<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Linker
 * 
 * @property int $id
 * @property string|null $url
 * @property string|null $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Linker extends Model
{
	protected $table = 'linker';

	protected $fillable = [
		'url',
		'slug'
	];




    public function scopeUrl($query, $url){
        return $query->where('url', '=', $url);
    }


    public function scopeSlug($query, $slug){
        return $query->where('slug', '=', $slug);
    }
}
