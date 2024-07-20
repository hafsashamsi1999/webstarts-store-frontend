<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 11 Feb 2020 15:36:33 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UserContact
 *
 * @property int $id
 * @property int $user_id
 * @property int $site_id
 * @property int $folder_id
 * @property string $name
 * @property string $email
 * @property string $client_username
 * @property string $client_password
 * @property int $status
 * @property string $hash
 * @property bool $type
 * @property int $formid
 * @property int $submission_id
 * @property int $wsc_listid
 *
 * @package App\Models
 */
class UserContact extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'site_id' => 'int',
		'folder_id' => 'int',
		'status' => 'int',
		'type' => 'bool',
		'formid' => 'int',
		'submission_id' => 'int',
		'wsc_listid' => 'int'
	];

	protected $hidden = [

	];

	protected $fillable = [
		'user_id',
		'site_id',
		'folder_id',
		'name',
		'email',
		'client_username',
		'client_password',
		'status',
		'hash',
		'type',
		'formid',
		'submission_id',
		'wsc_listid'
	];
}
