<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

/**
 * Class Token
 * 
 * @property int $id
 * @property string $token_id
 * @property string|null $data
 * @property int|null $status
 * @property Carbon|null $created_on
 *
 * @package App\Models
 */
class Token extends Model
{
	protected $table = 'tokens';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int',
		'data' => AsArrayObject::class,
	];

	protected $dates = [
		'created_on'
	];

	protected $fillable = [
		'token_id',
		'data',
		'status',
		'created_on'
	];
}
