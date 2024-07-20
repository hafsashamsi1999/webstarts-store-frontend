<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    //use HasFactory;
    protected $table = 'order_details';
    public $timestamps = false;

	protected $casts = [
		'order_id' => 'int',
		'product_id' => 'int',
		'product_name' => 'string',
		'description' => 'string',
		'setup_price' => 'float',
		'unit_price' => 'float',
		'next_price' => 'float',
		'quantity' => 'int',
		'tax_applied' => 'bool',
		'recurring' => 'int',
		'status' => 'bool',
		'display' => 'int',
		'timestamp' => 'datetime',
		'next_billing' => 'datetime',
		'notes' => 'string',
	];

	/* protected $dates = [
		'timestamp',
		'next_billing',
	]; */

	protected $fillable = [
		'order_id',
		'product_id',
		'product_name',
		'description',
		'setup_price',
		'unit_price',
		'next_price',
		'quantity',
		'tax_applied',
		'recurring',
		'status',
		'display',
		'timestamp',
		'next_billing',
		'notes',
	];

    /* ******************** RELATIONSHIPS ******************** */
	public function order()
	{
		return $this->belongsTo(\App\Models\Orders::class, 'order_id');
	}

    public function product()
	{
		return $this->belongsTo(\App\Models\Product::class, 'product_id');
	}
    /* ******************** RELATIONSHIPS ******************** */
}
