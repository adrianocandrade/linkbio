<?php
namespace Sandy\Blocks\shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
	protected $table = 'product_reviews';
	protected $fillable = [
		'user',
		'reviewer_id',
		'product_id',
		'rating',
		'review'
	];

	protected $casts = [
		'user' => 'int',
		'reviewer_id' => 'int',
		'product_id' => 'int'
	];
}
