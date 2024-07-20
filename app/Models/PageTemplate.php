<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 17 Jan 2020 20:08:21 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PageTemplate
 *
 * @property int $id
 * @property string $title
 * @property string $cover
 * @property int $is_live
 * @property int $sort_order
 * @property \Carbon\Carbon $timestamp
 *
 * @package App\Models
 */
class PageTemplate extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'is_live' => 'int',
		'sort_order' => 'int'
	];

	protected $dates = [
		'timestamp'
	];

	protected $fillable = [
		'title',
		'cover',
		'is_live',
		'sort_order',
		'timestamp'
	];

	public function data()
    {
    	$isLive = env("APP_ENV") == "local" ? 0 : 1;
    	$where = $isLive ? ['is_live', 1] : ['is_live', '<>', 2];
        return $this->hasMany(\App\Models\PageTemplateDetail::class, 'cat_id', 'id')->where([$where])->orderBy('sort_order');
    }
}
