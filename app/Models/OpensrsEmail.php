<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 18 Feb 2020 16:59:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class OpensrsEmail
 * 
 * @property int $email_id
 * @property string $email_name
 * @property int $domainid
 * @property string $firstname
 * @property string $lastname
 * @property string $password
 * @property int $userid
 * @property int $sale_id
 * @property bool $active
 *
 * @package App\Models
 */
class OpensrsEmail extends Eloquent
{
	protected $primaryKey = 'email_id';
	public $timestamps = false;

	protected $casts = [
		'domainid' => 'int',
		'userid' => 'int',
		'sale_id' => 'int',
		'active' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'email_name',
		'domainid',
		'firstname',
		'lastname',
		'password',
		'userid',
		'sale_id',
		'active'
	];

	/* Relationships */
	public function user()
	{
		return $this->belongsTo(App\Models\User::class, 'userid');
	}

	public function domain()
	{
		return $this->belongsTo(App\Models\Domaininfo::class, 'domainid');
	}
	/* Relationships */
}
