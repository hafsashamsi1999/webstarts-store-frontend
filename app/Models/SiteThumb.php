<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model;

/**
 * Class SiteThumb
 * 
 * @property int $id
 * @property int $siteid
 * @property string|null $viewport
 * @property string|null $url
 * @property string|null $s3file
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SiteThumb extends Model
{
	protected $table = 'site_thumbs';
	public $timestamps = false;

	protected $casts = [
		'siteid' => 'int',
		's3file' => 'array'
	];

	protected $fillable = [
		'siteid',
		'viewport',
		'url',
		's3file'
	];
}
