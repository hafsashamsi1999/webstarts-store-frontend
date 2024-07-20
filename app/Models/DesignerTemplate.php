<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 11 Oct 2019 18:46:24 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DesignerTemplate
 *
 * @property int $id
 * @property int $tid
 * @property int $ts_id
 * @property int $designerid
 *
 * @package App\Models
 */
class DesignerTemplate extends Model
{
	public $timestamps = false;

	protected $casts = [
		'tid' => 'int',
		'ts_id' => 'int',
		'designerid' => 'int'
	];

	protected $fillable = [
		'tid',
		'ts_id',
		'designerid'
	];

    public function templates()
    {
        return $this->hasMany(\App\Models\TemplateSet::class, 'id','ts_id');
    }
}
