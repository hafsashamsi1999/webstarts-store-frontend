<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 30 Oct 2019 20:41:07 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Designer
 *
 * @property int $id
 * @property int $userid
 *
 * @package App\Models
 */
class Designer extends Eloquent
{
	protected $table = 'designer';
	public $timestamps = false;

	protected $casts = [
		'userid' => 'int'
	];

	protected $fillable = [
		'userid'
	];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'userid');
    }

    public function templates()
    {
        return $this->hasMany(\App\Models\DesignerTemplate::class, 'designerid');
    }

    public function clients()
    {
        return $this->hasMany(\App\Models\DesignerClients::class, 'designerid');
    }

    public function domain()
    {
        return $this->hasOne(\App\Models\DesignerDomains::class, 'designerid');
    }

    public function options()
    {
        return $this->hasOne(\App\Models\DesignerOptions::class, 'designerid');
    }

}
