<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 06 Nov 2019 21:24:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DomainInvoices
 *
 * @property int $id
 * @property int $domain_id
 * @property string $domain
 * @property int $order_id
 * @property \Carbon\Carbon $expiry_date
 * @property bool $status
 * @property \Carbon\Carbon $reminder_last_sent
 * @property \Carbon\Carbon $expirynotice_last_sent
 * @property string $notes
 *
 * @package App\Models
 */
class DomainInvoices extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'domain_id' => 'int',
		'order_id' => 'int',
		'status' => 'bool'
	];

	protected $dates = [
		'expiry_date',
		'reminder_last_sent',
		'expirynotice_last_sent'
	];

	protected $fillable = [
		'domain_id',
		'domain',
		'order_id',
		'expiry_date',
		'status',
		'reminder_last_sent',
		'expirynotice_last_sent',
		'notes'
	];
}
