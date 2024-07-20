<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 04 Nov 2019 15:40:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DomainTransfers
 *
 * @property int $id
 * @property int $domain_id
 * @property string $auth_code
 * @property string $request
 * @property string $response
 * @property int $status
 * @property \Carbon\Carbon $created
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class DomainTransfers extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'domain_id' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'created',
		'updated'
	];

	protected $fillable = [
		'domain_id',
		'auth_code',
		'request',
		'response',
		'status',
		'created',
		'updated'
	];
}
