<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 17 Jan 2020 20:01:56 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SectionTemplateHtml
 *
 * @property int $id
 * @property int $cat_id
 * @property int $detail_id
 * @property string $html
 * @property string $css
 *
 * @package App\Models
 */
class SectionTemplateHtml extends Eloquent
{
	protected $table = 'section_template_html';
	public $timestamps = false;

	protected $casts = [
		'cat_id' => 'int',
		'detail_id' => 'int'
	];

	protected $fillable = [
		'cat_id',
		'detail_id',
		'html',
		'css'
	];
}
