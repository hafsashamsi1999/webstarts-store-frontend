<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 21 Oct 2019 22:36:43 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Payment
 * 
 * @property int $id
 * @property int $saleId
 * @property int $paymentTypeId
 * @property bool $transactionType
 * @property string $cardNumber
 * @property string $cardExpirationMonth
 * @property string $cardExpirationYear
 * @property string $cardCode
 * @property string $request
 * @property string $transactionId
 * @property \Carbon\Carbon $transactionTime
 * @property string $authorizationCode
 * @property string $authorizeNetRawResponse
 * @property bool $wasDeclined
 * @property string $paypalToken
 * @property string $paypalPayerId
 * @property string $stripeRawResponse
 * @property string $wepay_response
 * @property string $stripe_card_id
 * @property string $stripe_token
 *
 * @package App\Models
 */
class Payment extends Eloquent
{
	protected $table = 'payment';
	public $timestamps = false;

	protected $casts = [
		'saleId' => 'int',
		'paymentTypeId' => 'int',
		'transactionType' => 'bool',
		'wasDeclined' => 'bool'
	];

	protected $dates = [
		'transactionTime'
	];

	protected $hidden = [
		'stripe_token'
	];

	protected $fillable = [
		'saleId',
		'paymentTypeId',
		'transactionType',
		'cardNumber',
		'cardExpirationMonth',
		'cardExpirationYear',
		'cardCode',
		'request',
		'transactionId',
		'transactionTime',
		'authorizationCode',
		'authorizeNetRawResponse',
		'wasDeclined',
		'paypalToken',
		'paypalPayerId',
		'stripeRawResponse',
		'wepay_response',
		'stripe_card_id',
		'stripe_token'
	];
}
