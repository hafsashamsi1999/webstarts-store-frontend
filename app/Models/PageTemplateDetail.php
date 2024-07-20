<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 17 Jan 2020 20:09:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PageTemplateDetail
 *
 * @property int $id
 * @property string $title
 * @property string $thumb
 * @property int $sort_order
 * @property int $cat_id
 * @property int $is_live
 * @property object $thumb_size
 *
 * @package App\Models
 */
class PageTemplateDetail extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'sort_order' => 'int',
		'cat_id' => 'int',
		'is_live' => 'int',
		'thumb_size' => 'object'
	];

	protected $fillable = [
		'title',
		'thumb',
		'sort_order',
		'cat_id',
		'is_live',
		'thumb_size'
	];

    public function template()
    {
        return $this->belongsTo(\App\Models\PageTemplate::class, 'cat_id');
    }

    public function nodes()
    {
    	return $this->hasMany(\App\Models\PageTemplateHtml::class, 'detail_id');
    }
}
