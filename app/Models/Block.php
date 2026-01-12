<?php

namespace App\Models;

use App\Models\Base\Block as BaseBlock;

class Block extends BaseBlock
{
	protected $fillable = [
		'user',
		'workspace_id',
		'thumbnail',
		'name',
		'subheading',
		'block',
		'settings',
		'position'
	];

	protected $casts = [
		'settings' => 'array',
		'blocks' => 'array'
	];

    public function workspace() {
        return $this->belongsTo('App\Models\Workspace', 'workspace_id');
    }
}
