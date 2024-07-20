<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 17 Jan 2020 20:01:30 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SectionTemplateDetail
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
class SectionTemplateDetail extends Eloquent
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

	public function html()
    {
        return $this->hasMany(\App\Models\SectionTemplateHtml::class, 'detail_id', 'id');
    }
}
