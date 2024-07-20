<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model;

/**
 * Class ContributorInvite
 * 
 * @property int $id
 * @property string $invite_token
 * @property string $email
 * @property int $siteid
 * @property int $roleid
 * @property Carbon $invited_at
 *
 * @package App\Models
 */
class ContributorInvite extends Model
{
	protected $table = 'contributor_invites';
	public $timestamps = false;

	protected $casts = [
		'siteid' => 'int',
		'roleid' => 'int'
	];

	protected $dates = [
		'invited_at'
	];

	protected $hidden = [
		'invite_token'
	];

	protected $fillable = [
		'invite_token',
		'email',
		'siteid',
		'roleid',
		'invited_at'
	];
}
