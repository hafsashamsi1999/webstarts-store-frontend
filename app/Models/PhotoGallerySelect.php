<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 22 Oct 2019 16:40:26 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PhotoGallerySelect
 *
 * @property int $id
 * @property int $siteid
 * @property int $userid
 * @property int $pageid
 * @property int $albumId
 * @property string $photoids
 * @property int $status
 *
 * @package App\Models
 */
class PhotoGallerySelect extends Eloquent
{
	protected $table = 'photogallerySelect';
	public $timestamps = false;

	protected $casts = [
		'siteid' => 'int',
		'userid' => 'int',
		'pageid' => 'int',
		'albumId' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'siteid',
		'userid',
		'pageid',
		'albumId',
		'photoids',
		'status'
	];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'userid');
    }

    public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class, 'siteid');
    }

    public function page()
    {
        return $this->belongsTo(\App\Models\Pages::class, 'pageid');
    }
}
