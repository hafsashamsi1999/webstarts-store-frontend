<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 22 Oct 2019 16:34:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PhotoGallery
 *
 * @property int $id
 * @property int $userid
 * @property int $siteid
 * @property int $pageid
 * @property \Carbon\Carbon $published_date
 *
 * @package App\Models
 */
class PhotoGallery extends Eloquent
{
	protected $table = 'photogallery';
	public $timestamps = false;

	protected $casts = [
		'userid' => 'int',
		'siteid' => 'int',
		'pageid' => 'int'
	];

	protected $dates = [
		'published_date'
	];

	protected $fillable = [
		'userid',
		'siteid',
		'pageid',
		'published_date'
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

    public function makeEntriesFromFile($site=null)
    {
        if( $site )
        {

            $json_file = '/gallery.json';

            if($site->storage()->fileExists($json_file))
            {
                $data_str = $site->storage()->readPage($json_file);
                $data = json_decode($data_str, true);

                foreach ($data as $data_pg)
                {
                    $pageid = Pages::where('siteid','=',$site->id)
                                    ->select('id')
                                    ->where('name','LIKE',$data_pg['page_name'])
                                    ->where('active','=',1)
                                    ->first();
                    // If pageid is not fetched, then this throws many errors
                    if(is_null($pageid))
                        continue;

                    $photoGallery = self::create([
                        'userid' => $site->userid,
                        'siteid' => $site->id,
                        'pageid' => $pageid,
                        'published_date' => date("Y-m-d H:i:s")
                    ]);
                    $ids = array();
                    foreach ($data_pg['data'] as $key=>$val)
                    {
                        $pl = PhotoGalleryList::create([
                            'albumid' => $photoGallery->id,
                            'userid' => $site->userid,
                            'siteid' => $site->id,
                            'pageid' => $pageid,
                            'thumbnail' => $val['thumbnail'],
                            'large' => $val['large']
                        ]);
                        $ids[] = $pl->id;
                    }

                    $ps = new photogallerySelect();
                    PhotoGallerySelect([
                        'userid' => $site->userid,
                        'siteid' => $site->id,
                        'pageid' => $pageid,
                        'albumId' => $photoGallery->id,
                        'status' => 1,
                        'photoids' => implode(",", $ids)
                    ]);

                    $this->updateIdInHTML($data_pg['page_name'], $site, $data_pg['id'], $ps->id);

                }
                $site->storage()->delete($json_file);
            }
        }
    }

    private function updateIdInHTML($file, $site, $old_pg_id, $pg_id)
    {

        $html = $site->storage()->readPage($file);

        $updated_url = '"https://photogallery.plugins.editor.apps.webstarts.com/get.php?uid='.$site->userid.
            '&sid='.$site->id.'&aSelectionId='.$pg_id.'&layout=simple&output=js"';
        $pattern = '%"https?://photogallery\.plugins\.editor\.apps\.webstarts\.com/get\.php\?.*?aSelectionId='.$old_pg_id.'.*?"%si';

        if(preg_match($pattern, $html)){
            $_html = preg_replace($pattern, $updated_url, $html);
        }

        if( !empty($_html) && $_html != $html){
            $site->storage()->writePage($file, $_html);
        }
    }

}
