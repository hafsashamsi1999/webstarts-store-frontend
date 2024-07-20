<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Oct 2019 20:54:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BlogApi
 *
 * @property int $id
 * @property int $site_id
 * @property int $chat_entity_id
 * @property \Carbon\Carbon $created_at
 *
 * @package App\Models
 */
class ChatApi extends Eloquent
{
	protected $table = 'chat_api';
	public $timestamps = false;

	protected $casts = [
		'site_id' => 'int',
		'chat_entity_id' => 'int'
	];

	protected $fillable = [
		'site_id',
		'chat_entity_id'
	];

    // Relationships
    public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class, 'site_id');
    }

}
