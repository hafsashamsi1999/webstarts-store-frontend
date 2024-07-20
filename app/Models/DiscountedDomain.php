<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 17 Mar 2020 19:48:40 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DiscountedDomain
 * 
 * @property int $id
 * @property string $domain
 * @property int $productid
 * @property int $initial_orderid
 * @property float $discounted_price
 *
 * @package App\Models
 */
class DiscountedDomain extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'productid' => 'int',
		'initial_orderid' => 'int',
		'discounted_price' => 'float'
	];

	protected $fillable = [
		'domain',
		'productid',
		'initial_orderid',
		'discounted_price'
	];
}
