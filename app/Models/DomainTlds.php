<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 04 Nov 2019 15:40:16 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DomainTlds
 *
 * @property int $id
 * @property string $tld
 * @property float $price
 * @property string $term
 * @property bool $special
 * @property bool $active
 *
 * @package App\Models
 */
class DomainTlds extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'price' => 'float',
		'special' => 'bool',
		'active' => 'bool'
	];

	protected $fillable = [
		'tld',
		'price',
		'term',
		'special',
		'active'
	];

}
