<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 26 Oct 2019 20:17:03 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FBClients
 *
 * @property int $id
 * @property int $fb_user_id
 * @property int $client_id
 *
 * @package App\Models
 */
class FBClients extends Eloquent
{
	public $timestamps = false;
    protected $table = 'FB_Clients';
	protected $casts = [
		'fb_user_id' => 'int',
		'client_id' => 'int'
	];

	protected $fillable = [
		'fb_user_id',
		'client_id'
	];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'client_id');
    }

}
