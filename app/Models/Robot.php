<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Jan 2020 19:04:45 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Robot
 *
 * @property int $id
 * @property int $siteid
 * @property object $data
 *
 * @package App\Models
 */
class Robot extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'siteid' => 'int',
		'data' => 'object'
	];

	protected $fillable = [
		'siteid',
		'data'
	];

	public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class, 'siteid');
    }
}
