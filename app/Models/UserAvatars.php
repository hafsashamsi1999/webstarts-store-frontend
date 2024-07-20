<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 Oct 2019 20:16:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UserAvatars
 *
 * @property int $id
 * @property int $user_id
 * @property string $avatar_url
 *
 * @package App\Models
 */
class UserAvatars extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'avatar_url'
	];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
