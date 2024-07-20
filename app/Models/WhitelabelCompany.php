<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model;

/**
 * Class WhitelabelCompany
 * 
 * @property int $id
 * @property string $company_name
 * @property string $domain
 * @property string|null $fileserver
 * @property string|null $css
 * @property string|null $logo
 * @property string|null $editorLogo
 * @property string|null $getClicky_subDomain
 * @property string|null $getClicky_APIKEY
 * @property Carbon|null $timestamp
 * @property int|null $type
 * @property int|null $approved
 * @property int|null $active
 *
 * @package App\Models
 */
class WhitelabelCompany extends Model
{
	protected $table = 'whitelabel_company';
	public $timestamps = false;

	protected $casts = [
		'type' => 'int',
		'approved' => 'int',
		'active' => 'int'
	];

	protected $dates = [
		'timestamp'
	];

	protected $fillable = [
		'company_name',
		'domain',
		'fileserver',
		'css',
		'logo',
		'editorLogo',
		'getClicky_subDomain',
		'getClicky_APIKEY',
		'timestamp',
		'type',
		'approved',
		'active'
	];
}
