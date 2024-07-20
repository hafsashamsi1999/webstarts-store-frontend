<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 11 Oct 2019 20:34:13 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Template
 *
 * @property int $id
 * @property int $sid
 * @property string $title
 * @property int $isdefault
 * @property string $path
 * @property int $menu_id
 * @property int $des_id
 * @property int $isShow
 * @property bool $kh_menu_enabled
 * @property bool $elementMarked
 * @property string $extra
 * @property \Carbon\Carbon $created_at
 *
 * @package App\Models
 */
class Template extends Model
{
	protected $table = 'template';
	public $timestamps = false;

	protected $casts = [
		'sid' => 'int',
		'isdefault' => 'int',
		'menu_id' => 'int',
		'des_id' => 'int',
		'isShow' => 'int',
		'kh_menu_enabled' => 'bool',
		'elementMarked' => 'bool'
	];

	protected $fillable = [
		'sid',
		'title',
		'isdefault',
		'path',
		'menu_id',
		'des_id',
		'isShow',
		'kh_menu_enabled',
		'elementMarked',
		'extra'
	];

    public static function getHomePageFromHtaccess($template_id)
    {
        $home_pagename = false;
        $htaccess = "shared/themes/template/".$template_id."/.htaccess";
        $cs = new CommonStorage();
        $filecontent = $cs->readPage($htaccess);
        if($filecontent)
        {


            if (preg_match('/^DirectoryIndex[\s]*(.*?)$/im', $filecontent, $matches)) {
                $home_pagename = $matches[1];
            }
        }
        return $home_pagename;
    }

    public static function replace_template_resources_with_site($site=null)
    {
        if(is_null($site)) return

        $regex = '/static\.secure\.website\\\\\/ws-template-resources\\\\\/[0-9]*\\\\\//';
        $replacement = 'static.secure.website\/client-site-resources\/' . $site->id . '\/';

        $pagehead_files = $site->storage()->getFileListSite('include/pageheads/', array('file'), array('json'));
        foreach($pagehead_files as $pagehead_file)
        {
            $file = "include/pageheads/".$pagehead_file;
            $contents = $site->storage()->readPage($file);
            $contents = preg_replace($regex, $replacement, $contents);
            $site->storage()->writePage($file, $contents);
        }

        $file = "include/head.json";

        $contents = $site->storage()->readPage($file);
        if($contents)
        {
            $contents = preg_replace($regex, $replacement, $contents);
            $site->storage()->writePage($file, $contents);
        }
    }

}