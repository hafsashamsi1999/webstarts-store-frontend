<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model;

/**
 * Class InviterCode
 * 
 * @property int $id
 * @property int $user_id
 * @property string $code
 *
 * @package App\Models
 */
class InviterCode extends Model
{
	protected $table = 'inviter_codes';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'code'
	];
}
