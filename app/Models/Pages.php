<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 21 Oct 2019 16:01:15 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Utility\Sites\Dynamic\DynamicPageHead;

/**
 * Class Page
 *
 * @property int $id
 * @property int $siteid
 * @property string $title
 * @property int $parentId
 * @property string $name
 * @property string $url
 * @property int $templateId
 * @property bool $active
 * @property bool $displayOnMenu
 * @property int $menuId
 * @property bool $showMenu
 * @property int $pOrder
 * @property bool $phoneView
 * @property bool $external
 * @property bool $target
 * @property bool $isHomePage
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Pages extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'siteid' => 'int',
		'parentId' => 'int',
		'templateId' => 'int',
		'active' => 'bool',
		'displayOnMenu' => 'bool',
		'menuId' => 'int',
		'showMenu' => 'bool',
		'pOrder' => 'int',
		'phoneView' => 'bool',
		'external' => 'bool',
		'target' => 'bool',
		'isHomePage' => 'bool'
	];

	protected $fillable = [
		'siteid',
		'title',
		'parentId',
		'name',
		'url',
		'templateId',
		'active',
		'displayOnMenu',
		'menuId',
		'showMenu',
		'pOrder',
		'phoneView',
		'external',
		'target',
		'isHomePage'
	];

    public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class, 'siteid');
    }

    public function anchors()
    {
        return $this->hasMany(\App\Models\AnchorTag::class, 'pageid');
    }

    public static function getCommonPages()
    {
        return array(
            'index.html'=>'Home',
            'about.html'=>'About',
            'contact.html'=>'Contact',
            'photos.html'=>'Photos',
            'profile.html'=>'Profile'
        );
    }

    public static function getIdByName($siteid=0, $name='index.html', $external=0)
    {
        $where = [ ['siteid' ,'=', $siteid], ['name' ,'=', $name], ['external' ,'=', $external] ];
        $page = Pages::where($where)->first();
        return is_null($page) ? false : $page->id;
    }

    public static function getNameById($pageid=0, $siteid=0, $external=0)
    {
        $where = [ ['siteid' ,'=', $siteid], ['id' ,'=', $pageid], ['external' ,'=', $external] ];
        $page = Pages::where($where)->first();
        return is_null($page) ? false : $page->name;
    }

    public static function getByName($siteid=0, $name='index.html', $external=0)
    {
        $where = [ ['siteid' ,'=', $siteid], ['name' ,'=', $name], ['external' ,'=', $external] ];
        return Pages::where($where)->first();
    }

    public static function updatePagesData($site, $pages)
    {
        foreach ($pages as $page) {

            $displayOnMenu = isset($page['displayOnMenu']) ? $page['displayOnMenu'] : '1';

            // If this is a child page, then we need to get this site->page->parentId and update accordingly.
            if ($page['parentId'] > 0) {
                $page['parentId'] = self::getParentIdFromArray($page, $pages, $site->id);
            }

            $dataPage = [
                'target' => $page['target'],
                'external' => $page['external'],
                'pOrder' => $page['pOrder'],
                'showMenu' => 1,
                'menuId' => 0,
                'displayOnMenu' => $displayOnMenu,
                'active' => 1,
                'templateId' => 0,
                'url' => $page['url'],
                'parentId' => $page['parentId'],
                'title' => $page['title']
            ];

            if (isset($page['external']) AND ($page['external'] == '1' OR $page['external'] == 1)) { // If External link on menu

                $dataPage['siteid'] = $site->id;
                $dataPage['name'] = $page['name'];

                $tmpPage = Pages::create($dataPage);

            } else {
                if ( ! empty($page['name'])) {

                    $where = [['siteid' ,'=', $site->id],['name' ,'=', $page['name']]];

                    $tmpPage = Pages::where($where)->first();
                    if(!is_null($tmpPage)) {
                        Pages::update($tmpPage->id,$dataPage);
                    }
                }
            }

        }
    }

    public static function getParentIdFromArray($page = [], $pages = [], $siteid) {

        $parentId = 0;

        // Missing $page['parentName'] for $page['external']

        if( empty($page['parentName']) && ! empty($page['id']) ) {

            // Lets find parentName in array
            foreach ($pages as $_page) {
                if($_page['id'] == $page['parentId']) {

                    if(!empty($_page['name'])) {
                        $page['parentName'] = $_page['name'];
                    } else {
                        // (parent page name is empty) In this case, we don't have uniq thing to match
                        $where = [
                            ['external','=',$_page['external']],
                            ['name' ,'=', $_page['name']],
                            ['pOrder' ,'=', $_page['pOrder']],
                            ['url' ,'=', $_page['url']],
                            ['title' ,'=', $_page['title']],
                            ['siteid' ,'=', $siteid]
                        ];

                        $tmpPage = Pages::where($where)->first();
                    }

                    break;
                }
            }
        }

        if( !empty($page['parentName']) ) {
            $tmpPage = Pages::where([
                ['siteid','=',$siteid],
                ['name','LIKE',$page['parentName']],
                ['external','=',0]
            ])->first();
        }

        return !is_null($tmpPage) ? $tmpPage->id : 0 ;
    }

    public static function getNextSortOrder($siteid)
    {
        $last = Pages::where('siteid','=',$siteid)->max('pOrder');
        if(is_numeric($last)){
            return $last  + 1;
        }
        return '0';
    }

    public function mirror_viewport_from_pagehead($Site = null)
    {
        $this->phoneView = 0;

        if( ! isset($Site) || is_null($Site))
        {
            $Site = Sites::where('id','=',$this->siteid)->first();
            if(is_null($Site))
            {
                $this->save();
                return;
            }
        }

        $PageHead = new DynamicPageHead($this->name,$Site->storage());
        $page_json = $PageHead->load_json();

        $entity = $PageHead->getEntityById($page_json, 'convertedViewports');
        if(empty($entity))
        {
            $this->save();
            return;
        }

        $viewports = isset($entity['value']) ? explode('|', $entity['value']) : array();
        if( ! empty($viewports))
        {
            if(in_array('phone', $viewports))
            {
                $this->phoneView = 1;
            }
        }
        $this->save();
    }

}
