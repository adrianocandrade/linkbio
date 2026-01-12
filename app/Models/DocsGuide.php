<?php

namespace App\Models;

use App\Models\Base\DocsGuide as BaseDocsGuide;

class DocsGuide extends BaseDocsGuide
{
	protected $fillable = [
		'name',
		'slug',
		'docs_category',
		'media',
		'content',
		'position'
	];

	protected $casts = [
		'media' => 'array',
		'content' => 'array'
	];
}
