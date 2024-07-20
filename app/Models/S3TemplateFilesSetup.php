<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Oct 2019 14:13:57 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class S3TemplateFilesSetup
 * 
 * @property int $id
 * @property int $templateid
 *
 * @package App\Models
 */
class S3TemplateFilesSetup extends Eloquent
{
	protected $table = 's3_template_files_setup';
	public $timestamps = false;

	protected $casts = [
		'templateid' => 'int'
	];

	protected $fillable = [
		'templateid'
	];
}
