<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 21 Oct 2019 23:00:28 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

/**
 * Class Order
 *
 * @property int $id
 * @property string $order_id
 * @property int $parent_id
 * @property int $sibling_id
 * @property int $customer_id
 * @property int $site_id
 * @property int $company_id
 * @property float $amount
 * @property \Carbon\Carbon $timestamp
 * @property int $paid
 * @property int $auto_pay
 * @property int $sent
 * @property bool $status
 * @property int $display
 * @property int $invoice_id
 * @property string $processor
 *
 * @property \Illuminate\Database\Eloquent\Collection $order_addyears
 *
 * @package App\Models
 */
class Orders extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'parent_id' => 'int',
		'sibling_id' => 'int',
		'customer_id' => 'int',
		'site_id' => 'int',
		'company_id' => 'int',
		'amount' => 'float',
		'timestamp' => 'datetime',
		'paid' => 'int',
		'auto_pay' => 'int',
		'sent' => 'int',
		'status' => 'bool',
		'display' => 'int',
		'invoice_id' => 'int',
		'processor' => 'string',
		'trial_days' => 'int',
	];

	protected $fillable = [
		'order_id',
		'parent_id',
		'sibling_id',
		'customer_id',
		'site_id',
		'company_id',
		'amount',
		'timestamp',
		'paid',
		'auto_pay',
		'sent',
		'status',
		'display',
		'invoice_id',
		'processor',
		'trial_days',
	];

	/* ******************** RELATIONSHIPS ******************** */
	public function orderDetails()
	{
		return $this->hasMany(\App\Models\OrderDetails::class,'order_id');
	}

    public function orderAddyears()
    {
        return $this->hasOne(\App\Models\OrderAddyears::class,'order_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class,'customer_id');
    }

	public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class,'site_id');
    }

    public function domainInvoice()
    {
        return $this->hasOne(\App\Models\DomainInvoices::class, 'order_id');
    }

    public function domains()
    {
        return $this->hasMany(\App\Models\Domaininfo::class, 'order_id');
    }
	/* ******************** RELATIONSHIPS ******************** */




    public function hasActivePaidInvoice($customer_id, $site_id=false)
    {
        if ($site_id){
            $binding = "o.site_id = :id";
            $bindParam = ['id' => $site_id];
        } else {
            $binding = "o.customer_id = :id";
            $bindParam = ['id' => $customer_id];
        }

        /*
         * NOTE for below query
         * o.status IN(1,3) AND od.status IN(1,3) In this part status=1 means has active paid invoice and status=3 means a new invoice
         * has been generated from this invoice but this one is still not expired yet will be checked in AND od.next_billing >= DATE_ADD( DATE_FORMAT part.
         */
        $sql = "SELECT o.id AS orderid, p.id, p.name, p.pcode, p.package_id, pkg.type, pkg.category
						FROM orders AS o, order_details AS od, product AS p LEFT OUTER JOIN packages AS pkg
						ON 	pkg.id = p.package_id
						WHERE
							od.product_id = p.id
							AND p.type != '0'
							AND od.product_id NOT IN(46,0)
							AND od.order_id = o.id
							AND o.paid = 1
							AND o.status IN(1,3)
							AND od.status IN(1,3)
							AND $binding
							AND od.next_billing >= DATE_ADD( DATE_FORMAT(NOW(),'%Y-%m-%d'), INTERVAL -1 MONTH) ORDER BY o.id DESC LIMIT 1;";

        $results = DB::select($sql, $bindParam);
        return !empty($results) ? $results : false;
    }

    public function hasPaidInvoiceByProductGroup($site_id, $product_group)
    {
        $orders = array();
        if (empty($site_id) OR empty($product_group) )
            return $orders;

        /*
         * NOTE for below query
         * o.status IN(1,3) AND od.status IN(1,3) In this part status=1 means has active paid invoice and status=3 means a new invoice
         * has been generated from this invoice but this one is still not expired yet will be checked in AND od.next_billing >= DATE_ADD( DATE_FORMAT part.
         */
        $sql = "SELECT o.id AS orderid, o.timestamp AS order_timestamp, p.id AS productid, p.name, p.pcode, p.package_id, pkg.type, pkg.category
						FROM orders AS o, order_details AS od, product AS p, packages AS pkg
						WHERE
							o.id = od.order_id AND
							od.product_id = p.id AND
							p.package_id = pkg.id AND
							o.site_id = :sid AND
							o.paid = 1 AND
							o.status IN(1,3) AND
							od.status IN(1,3) AND
							od.next_billing >= DATE_ADD( DATE_FORMAT(NOW(),'%Y-%m-%d'), INTERVAL -1 MONTH) AND
							pkg.category IN ('PRO', 'PROPLUS', 'BUSINESSPRO', 'BUSINESSPROPLUS') AND
							pkg.product_group = :pg ORDER BY o.timestamp DESC";

        $results = DB::select($sql, ['sid'=>$site_id,'pg'=>$product_group]);
        return $results;
    }

}
