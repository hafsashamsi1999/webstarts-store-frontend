<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 31 Oct 2019 18:39:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DesignerDomains
 *
 * @property int $id
 * @property int $designerid
 * @property int $domainid
 * @property string $domain
 * @property string $cart_domain
 *
 * @package App\Models
 */
class DesignerDomains extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'designerid' => 'int',
		'domainid' => 'int'
	];

	protected $fillable = [
		'designerid',
		'domainid',
		'domain',
		'cart_domain'
	];

    public function designer()
    {
        return $this->belongsTo(\App\Models\Designer::class, 'designerid');
    }
}
