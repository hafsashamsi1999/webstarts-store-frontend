<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model;

/**
 * Class IpAddress
 * 
 * @property int $id
 * @property string|null $ip
 * @property string|null $response
 * @property int $block
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class IpAddress extends Model
{
	protected $table = 'ip_address';
	public $timestamps = false;

	protected $casts = [
		'block' => 'int'
	];

	protected $fillable = [
		'ip',
		'response',
		'block'
	];

	protected $dates = [
		'updated_at'
	];
}
