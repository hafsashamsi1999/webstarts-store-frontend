<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model;

/**
 * Class Adminuser
 * 
 * @property int $id
 * @property string $username
 * @property string|null $password
 * @property int|null $clientId
 * @property int $level
 * @property bool $isActive
 *
 * @package App\Models
 */
class Adminuser extends Model
{
	protected $table = 'adminusers';
	public $timestamps = false;

	protected $casts = [
		'clientId' => 'int',
		'level' => 'int',
		'isActive' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'username',
		'password',
		'clientId',
		'level',
		'isActive'
	];
}
