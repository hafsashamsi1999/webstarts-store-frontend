<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 22 Oct 2019 16:40:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PhotoGalleryList
 *
 * @property int $id
 * @property int $albumid
 * @property int $userid
 * @property int $siteid
 * @property int $pageid
 * @property string $thumbnail
 * @property string $large
 *
 * @package App\Models
 */
class PhotoGalleryList extends Eloquent
{
	protected $table = 'photogallery_list';
	public $timestamps = false;

	protected $casts = [
		'albumid' => 'int',
		'userid' => 'int',
		'siteid' => 'int',
		'pageid' => 'int'
	];

	protected $fillable = [
		'albumid',
		'userid',
		'siteid',
		'pageid',
		'thumbnail',
		'large'
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
