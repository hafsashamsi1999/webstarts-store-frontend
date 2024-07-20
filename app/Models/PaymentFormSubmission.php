<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 10 Feb 2020 21:14:40 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PaymentFormSubmission
 * 
 * @property int $id
 * @property int $submission_id
 * @property string $payment_processor
 * @property string $payment_currency
 * @property float $payment_amount
 * @property string $payment_item
 * @property int $payment_complete
 * @property string $payment_description
 *
 * @package App\Models
 */
class PaymentFormSubmission extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'submission_id' => 'int',
		'payment_amount' => 'float',
		'payment_complete' => 'int'
	];

	protected $fillable = [
		'submission_id',
		'payment_processor',
		'payment_currency',
		'payment_amount',
		'payment_item',
		'payment_complete',
		'payment_description'
	];
}
