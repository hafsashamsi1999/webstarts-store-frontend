<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 03 Nov 2019 14:55:15 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Domaininfo
 *
 * @property int $id
 * @property int $userid
 * @property int $saleid
 * @property string $domain
 * @property int $type
 * @property bool $is_https
 * @property int $cart_user_id
 * @property string $is_shopping_cart_domain
 * @property string $email_username
 * @property string $email_password
 * @property string $email_url
 * @property string $email_type
 * @property int $site_id
 * @property int $sale_id
 * @property int $order_id
 * @property int $dr_status
 * @property int $lock_state
 * @property int $privacy
 * @property \Carbon\Carbon $creation_date
 * @property \Carbon\Carbon $updation_date
 * @property \Carbon\Carbon $expiry_date
 * @property \Carbon\Carbon $revoke_date
 * @property \Carbon\Carbon $last_renewed_date
 * @property string $renewed_response
 * @property int $renewed_status
 * @property \Carbon\Carbon $req_datetime
 * @property int $req_status
 * @property string $res_rowdata
 * @property int $res_status
 * @property string $r_name
 * @property string $r_address
 * @property string $r_city
 * @property string $r_state
 * @property string $r_country
 * @property string $r_postalcode
 * @property string $r_org
 * @property string $r_telephone
 * @property string $r_email
 * @property string $a_name
 * @property string $a_address
 * @property string $a_city
 * @property string $a_state
 * @property string $a_country
 * @property string $a_postalcode
 * @property string $a_org
 * @property string $a_telephone
 * @property string $a_email
 * @property string $t_name
 * @property string $t_address
 * @property string $t_city
 * @property string $t_state
 * @property string $t_country
 * @property string $t_postalcode
 * @property string $t_org
 * @property string $t_telephone
 * @property string $t_email
 * @property string $b_name
 * @property string $b_address
 * @property string $b_city
 * @property string $b_state
 * @property string $b_country
 * @property string $b_postalcode
 * @property string $b_org
 * @property string $b_telephone
 * @property string $b_email
 *
 * @package App\Models
 */
class Domaininfo extends Eloquent
{
	protected $table = 'domaininfo';
	public $timestamps = false;

    /* NOTE: dr_status (Domain Renewal Status) possible values to be used only for our internal webstarts application and does not have any relation with OpenSRS
        1= Active - Invoices generate normally. Setting a domain to 'active' would remove domain parking if already set.
        2= Suspended - Invoices generate normally. Domain is parked using API.
        3= Canceled - Invoices will not generate. Domain is parked using API.
        4= LetExpire - Invoices will not generate. Setting a domain to 'Let Expire' would remove domain parking if already set.
        For domain parking status, see $domain_park_values
    */
    // To be shown in dropdown at UI
    //public static $dr_status_values   = [1=>'Active', 2=>'Suspended', 3=>'Canceled', 4=>'LetExpire'];

	protected $casts = [
		'userid' => 'int',
		'saleid' => 'int',
		'type' => 'int',
		'is_https' => 'bool',
		'cart_user_id' => 'int',
		'site_id' => 'int',
		'sale_id' => 'int',
		'order_id' => 'int',
		'dr_status' => 'int',
		'lock_state' => 'int',
		'privacy' => 'int',
		'renewed_status' => 'int',
		'req_status' => 'int',
		'res_status' => 'int'
	];

	protected $dates = [
		'creation_date',
		'updation_date',
		'expiry_date',
		'revoke_date',
		'last_renewed_date',
		'req_datetime'
	];

	protected $hidden = [
		'email_password'
	];

	protected $fillable = [
		'userid',
		'saleid',
		'domain',
		'type',
		'is_https',
		'cart_user_id',
		'is_shopping_cart_domain',
		'email_username',
		'email_password',
		'email_url',
		'email_type',
		'site_id',
		'sale_id',
		'order_id',
		'dr_status',
		'lock_state',
		'privacy',
		'creation_date',
		'updation_date',
		'expiry_date',
		'revoke_date',
		'last_renewed_date',
		'renewed_response',
		'renewed_status',
		'req_datetime',
		'req_status',
		'res_rowdata',
		'res_status',
		'r_name',
		'r_address',
		'r_city',
		'r_state',
		'r_country',
		'r_postalcode',
		'r_org',
		'r_telephone',
		'r_email',
		'a_name',
		'a_address',
		'a_city',
		'a_state',
		'a_country',
		'a_postalcode',
		'a_org',
		'a_telephone',
		'a_email',
		't_name',
		't_address',
		't_city',
		't_state',
		't_country',
		't_postalcode',
		't_org',
		't_telephone',
		't_email',
		'b_name',
		'b_address',
		'b_city',
		'b_state',
		'b_country',
		'b_postalcode',
		'b_org',
		'b_telephone',
		'b_email'
	];

    /* Relationships */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'userid');
    }

    public function domainRecords()
    {
        return $this->hasOne(\App\Models\Domaincp::class, 'domainid');
    }

    public function domainStatus()
    {
        return $this->hasOne(\App\Models\DomainStatus::class, 'domain_id');
    }

    public function domainTransfers()
    {
        return $this->hasOne(\App\Models\DomainTransfers::class, 'domain_id');
    }

    public function opensrs_emails()
    {
        return $this->hasMany(App\Models\OpensrsEmail::class, 'domainid');
    }
    /* Relationships */

    public function scopeNotPlaceholders($query)
    {
        return $query->where('domain', '!=', '__DOMAIN__');
    }

    /*public static function getRegistrar($data)
    {
        if(preg_match('/clTRID="webstartsapi/', $data))
            $registrar = 'wwd';
        else if(preg_match('/Server: OpenSRS\/XML-RSA Server/', $data))
            $registrar = 'opensrs';
        else
            $registrar = false;

        return $registrar;
    }*/


    // Instead of this, use App\Helpers\WebstartsHelper::__fqdn
    /*public static function fd( $domain, $replace=false )
    {
        if( !$domain )
            return false;

        $str = '';
        if(!$replace)
            $str = 'http://www.';

        return $str . str_replace(array('http://www.', 'http://', 'www.'), '', $domain);
    }*/
}
