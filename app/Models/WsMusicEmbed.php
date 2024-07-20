<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 20 Jan 2020 22:34:43 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class WsMusicEmbed
 *
 * @property int $id
 * @property int $site_id
 * @property int $app_id
 * @property string $token
 *
 * @package App\Models
 */
class WsMusicEmbed extends Eloquent
{
	public $timestamps = false;
	protected $table = 'ws_music_embeds';

	protected $casts = [
		'site_id' => 'int',
		'app_id' => 'int',
	];

	protected $fillable = [
		'site_id',
		'app_id',
	];

    public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class, 'site_id');
    }
}
