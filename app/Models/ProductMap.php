<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 17 Jan 2020 19:06:15 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductMap
 * 
 * @property int $id
 * @property string $name
 * @property int $monthly
 * @property int $yearly
 * @property string $save_badge
 *
 * @package App\Models
 */
class ProductMap extends Eloquent
{
	protected $table = 'product_map';
	public $timestamps = false;

	protected $casts = [
		'monthly' => 'int',
		'yearly' => 'int'
	];

	protected $fillable = [
		'name',
		'monthly',
		'yearly',
		'save_badge'
	];
}
