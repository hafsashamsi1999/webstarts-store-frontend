<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 30 Jan 2020 23:10:57 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Sitestat
 *
 * @property int $id
 * @property int $ws_userid
 * @property int $ws_siteid
 * @property string $clicky_userid
 * @property string $clicky_siteid
 * @property string $clicky_sitekey
 * @property string $clicky_db
 * @property int $ws_company_id
 * @property string $clicky_login_id
 * @property string $clicky_password
 *
 * @package App\Models
 */
class Sitestats extends Eloquent
{
	protected $table = "sitestats";

	public $timestamps = false;

	protected $casts = [
		'ws_userid' => 'int',
		'ws_siteid' => 'int',
		'ws_company_id' => 'int'
	];

	protected $hidden = [
		'clicky_password'
	];

	protected $fillable = [
		'ws_userid',
		'ws_siteid',
		'clicky_userid',
		'clicky_siteid',
		'clicky_sitekey',
		'clicky_db',
		'ws_company_id',
		'clicky_login_id',
		'clicky_password'
	];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'ws_userid');
    }

    public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class, 'ws_siteid');
    }
}
