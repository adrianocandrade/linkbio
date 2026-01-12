<?php

namespace App\Models;

use App\Models\Base\DocsCategory as BaseDocsCategory;

class DocsCategory extends BaseDocsCategory
{
	protected $fillable = [
		'name',
		'slug',
		'media',
		'position'
	];
}
