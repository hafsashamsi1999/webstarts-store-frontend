<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 17 Mar 2020 18:04:00 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DomainStatus
 * 
 * @property int $id
 * @property int $domain_id
 * @property string $domain
 * @property bool $ns1
 * @property bool $ns2
 * @property bool $host
 * @property bool $tracking
 * @property bool $email
 * @property \Carbon\Carbon $date
 * 
 * @property \App\Models\Domaininfo $domaininfo
 *
 * @package App\Models
 */
class DomainStatus extends Eloquent
{
	protected $table = 'domain_status';
	public $timestamps = false;

	protected $casts = [
		'domain_id' => 'int',
		'ns1' => 'bool',
		'ns2' => 'bool',
		'host' => 'bool',
		'tracking' => 'bool',
		'email' => 'bool'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'domain_id',
		'domain',
		'ns1',
		'ns2',
		'host',
		'tracking',
		'email',
		'date'
	];

	public function domaininfo()
	{
		return $this->belongsTo(\App\Models\Domaininfo::class, 'domain_id');
	}
}
