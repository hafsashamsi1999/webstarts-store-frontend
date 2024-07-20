<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 11 Oct 2019 18:18:16 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TemplateMapping
 * 
 * @property int $sid
 * @property int $cid
 *
 * @package App\Models
 */
class TemplateMapping extends Model
{
	protected $table = 'template_mapping';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'sid' => 'int',
		'cid' => 'int'
	];
}