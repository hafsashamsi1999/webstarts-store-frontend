<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 21 Oct 2019 22:36:04 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Purchasedetail
 *
 * @property int $id
 * @property int $userId
 * @property int $saleId
 * @property int $domainnames
 * @property int $emailaccounts
 * @property int $webpages
 * @property int $websites
 * @property int $storagespace
 * @property int $bandwidth
 * @property string $phonesupport
 * @property string $features
 *
 * @package App\Models
 */
class PurchaseDetails extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'userId' => 'int',
		'saleId' => 'int',
		'domainnames' => 'int',
		'emailaccounts' => 'int',
		'webpages' => 'int',
		'websites' => 'int',
		'storagespace' => 'int',
		'bandwidth' => 'int'
	];

	protected $fillable = [
		'userId',
		'saleId',
		'domainnames',
		'emailaccounts',
		'webpages',
		'websites',
		'storagespace',
		'bandwidth',
		'phonesupport',
		'features'
	];
}
