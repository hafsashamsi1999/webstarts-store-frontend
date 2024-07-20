<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 24 Oct 2019 13:19:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SiteUser
 *
 * @property int $id
 * @property int $siteID
 * @property int $userID
 * @property int $cart_user_id
 * @property int $cart_login_id
 * @property bool $status
 *
 * @package App\Models
 */
class SiteUser extends Eloquent
{
	protected $table = 'SiteUser';
	public $timestamps = false;

	protected $casts = [
		'siteID' => 'int',
		'userID' => 'int',
		'cart_user_id' => 'int',
		'cart_login_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'siteID',
		'userID',
		'cart_user_id',
		'cart_login_id',
		'status'
	];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'userID');
    }

    public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class, 'siteID');
    }
}
