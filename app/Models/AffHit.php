<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model;

/**
 * Class AffHit
 * 
 * @property int $id
 * @property int $affiliateid
 * @property string $type
 * @property Carbon $timestamp
 *
 * @package App\Models
 */
class AffHit extends Model
{
	protected $table = 'aff_hits';
	public $timestamps = false;

	protected $casts = [
		'affiliateid' => 'int'
	];

	protected $dates = [
		'timestamp'
	];

	protected $fillable = [
		'affiliateid',
		'type',
		'timestamp'
	];
}
