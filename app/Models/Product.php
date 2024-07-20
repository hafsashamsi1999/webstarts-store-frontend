<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 21 Oct 2019 22:29:44 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Product
 *
 * @property int $id
 * @property string $pcode
 * @property string $name
 * @property string $simple_name
 * @property string $description
 * @property string $statement_descriptor
 * @property string $expiry_text
 * @property float $price
 * @property float $next_price
 * @property float $setupfee
 * @property float $beforeprice
 * @property float $upsell
 * @property bool $pageeditor
 * @property int $domainnames
 * @property int $emailaccounts
 * @property int $webpages
 * @property int $websites
 * @property int $storagespace
 * @property int $bandwidth
 * @property string $phonesupport
 * @property bool $active
 * @property bool $type
 * @property bool $recursion
 * @property string $extra
 * @property int $package_id
 * @property int $companyId
 * @property string $features
 * @property bool $display
 * @property int $priority
 * @property bool $isUpsale
 * @property bool $multiyear
 *
 * @package App\Models
 */
class Product extends Eloquent
{
	protected $table = 'product';
	public $timestamps = false;

	protected $casts = [
		'price' => 'float',
		'next_price' => 'float',
		'setupfee' => 'float',
		'beforeprice' => 'float',
		'upsell' => 'float',
		'pageeditor' => 'bool',
		'domainnames' => 'int',
		'emailaccounts' => 'int',
		'webpages' => 'int',
		'websites' => 'int',
		'storagespace' => 'int',
		'bandwidth' => 'int',
		'active' => 'bool',
		'type' => 'bool',
		'recursion' => 'int',
		'package_id' => 'int',
		'companyId' => 'int',
		'display' => 'bool',
		'priority' => 'int',
		'isUpsale' => 'bool',
		'multiyear' => 'bool',
        'features' => 'array',
		'trial_days' => 'int',
	];

	protected $fillable = [
		'pcode',
		'name',
		'simple_name',
		'description',
		'statement_descriptor',
		'expiry_text',
		'price',
		'next_price',
		'setupfee',
		'beforeprice',
		'upsell',
		'pageeditor',
		'domainnames',
		'emailaccounts',
		'webpages',
		'websites',
		'storagespace',
		'bandwidth',
		'phonesupport',
		'active',
		'type',
		'recursion',
		'extra',
		'package_id',
		'companyId',
		'features',
		'display',
		'priority',
		'isUpsale',
		'multiyear',
		'trial_days',
	];

    public function package()
    {
        return $this->belongsTo(\App\Models\Packages::class, 'package_id');
    }

	public static function hasPurchased($pcode, $userid,$siteid)
    {
        $product = self::where("pcode","LIKE",$pcode)->first();
        if(!is_null($product)) {
            $purchased = Sale::where("customerId","=",$userid)
                ->where("productId","=",$product->id)
                ->where("site_id","=",$siteid)
                ->where("isComplete","=",1)
                ->first();
            if(!is_null($purchased)) {
                return true;
            }
        }
        return false;
    }
}
