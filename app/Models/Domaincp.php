<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 03 Nov 2019 14:55:24 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Domaincp
 * 
 * @property int $id
 * @property int $domainid
 * @property string $NS
 * @property string $MX
 * @property string $CNAME
 * @property string $A
 * @property string $TXT
 * @property string $Extras
 * @property string $SOA
 * @property string $nsresponse
 * @property string $forwarding
 *
 * @package App\Models
 */
class Domaincp extends Eloquent
{
	protected $table = 'domaincp';
	public $timestamps = false;

	protected $casts = [
		'domainid' => 'int'
	];

	protected $fillable = [
		'domainid',
		'NS',
		'MX',
		'CNAME',
		'A',
		'TXT',
		'Extras',
		'SOA',
		'nsresponse',
		'forwarding'
	];
}
