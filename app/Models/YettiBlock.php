<?php

namespace App\Models;

use App\Models\Base\YettiBlock as BaseYettiBlock;

class YettiBlock extends BaseYettiBlock
{
	protected $fillable = [
		'user',
		'workspace_id',
		'block',
		'title',
		'extra',
		'position'
	];

	
	protected $casts = [
		'extra' => 'array',
		'blocks' => 'array'
	];
    
    public function workspace() {
        return $this->belongsTo('App\Models\Workspace', 'workspace_id');
    }
}
