<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 21 Oct 2019 22:29:19 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Sale
 *
 * @property int $id
 * @property int $customerId
 * @property int $site_id
 * @property int $productId
 * @property bool $isComplete
 * @property \Carbon\Carbon $timestamp
 * @property bool $productUpsell
 * @property float $productAmount
 * @property float $setupFee
 * @property string $upsellId
 * @property float $upsellAmount
 * @property bool $saleType
 * @property int $InvoiceId
 * @property string $processor
 *
 * @package App\Models
 */
class Sale extends Eloquent
{
	protected $table = 'sale';
	public $timestamps = false;

	protected $casts = [
		'customerId' => 'int',
		'site_id' => 'int',
		'productId' => 'int',
		'isComplete' => 'bool',
		'productUpsell' => 'bool',
		'productAmount' => 'float',
		'setupFee' => 'float',
		'upsellAmount' => 'float',
		'saleType' => 'bool',
		'InvoiceId' => 'int'
	];

	protected $dates = [
		'timestamp'
	];

	protected $fillable = [
		'customerId',
		'site_id',
		'productId',
		'isComplete',
		'timestamp',
		'productUpsell',
		'productAmount',
		'setupFee',
		'upsellId',
		'upsellAmount',
		'saleType',
		'InvoiceId',
		'processor'
	];

    public function domains()
    {
        return $this->hasMany(\App\Models\Domaininfo::class, 'sale_id');
    }
}
