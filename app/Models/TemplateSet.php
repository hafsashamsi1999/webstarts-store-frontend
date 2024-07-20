<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 11 Oct 2019 20:11:19 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TemplateSet
 * 
 * @property int $id
 * @property string $title
 * @property string $type
 * @property int $status
 * @property int $app_version
 * @property int $popular
 * @property string $tags
 * @property int $isShow
 * @property int $public
 * @property int $designer_owned
 * @property bool $dynamic
 *
 * @package App\Models
 */
class TemplateSet extends Model
{
	protected $table = 'template_set';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int',
		'app_version' => 'int',
		'popular' => 'int',
		'isShow' => 'int',
		'public' => 'int',
		'designer_owned' => 'int',
		'dynamic' => 'bool'
	];

	protected $fillable = [
		'title',
		'type',
		'status',
		'app_version',
		'popular',
		'tags',
		'isShow',
		'public',
		'designer_owned',
		'dynamic'
	];

    public static function get_templates($config)
    {
        $baseQuery = \App\Models\TemplateSet::select('template_set.id', 'template_set.title', 'template_set.description', 'template_set.url_slug')
			        	->where(function($query) use ($config) {

					    	switch ($config['type']) {
					    		default:
					    		case 'stock':
					    			$query->where('template_set.status', '1')->where('template_set.isShow', '1');
					    		break;

					    		case 'community':
					    			$query->where('template_set.status', '1')->where('template_set.public', '1')->where('template_set.designer_owned', '1');
					    		break;

					    		case 'designer':
					    			$dTemplates = \App\Models\DesignerTemplate::select('ts_id')->where('designerid', $config['designerid'])->get();
					    			$tsids = collect($dTemplates->toArray())->flatten()->toArray();
					    			$query->whereIn('id', $tsids);
					    		break;
					    	}

				        });

        if(isSet($config['cat'])) {
        	if( ! is_numeric($config['cat'])) {
        		$category = \App\Models\TemplateCategory::where('status', '2')->where('name', $config['cat'])->first();

				if(!empty($category)) {
					$config['cat'] = $category->id;
				} else {
					$config['cat'] = 0;
				}
        	}

        	$baseQuery->leftJoin('template_mapping', 'template_set.id', '=', 'template_mapping.sid');
        	$baseQuery->leftJoin('template_categories', 'template_categories.id', '=', 'template_mapping.cid');
        	$baseQuery->where('template_categories.id', $config['cat']);

        } else if(! empty($config['keyword'])) {
        	$keyword = trim($config['keyword']);
        	$keyword_regex = preg_replace('%[\s]+%', '|', $keyword);
        	$baseQuery->where('template_set.tags', 'REGEXP', $keyword_regex);
        }

    	$dynamic = (isSet($config['dynamic']) && $config['dynamic']) ? "1" : "0";
        $sortBy = 'popular';

        if(isSet($config['sortBy'])) {

            if($config['sortBy'] == 'newest') {
                $sortBy = 'id';
            } else if($config['sortBy'] == 'popularity') {
                $sortBy = 'popular';
            }
        }

        $baseQuery->where('dynamic', $dynamic);
    	$templateSets = $baseQuery->orderBy($sortBy, 'DESC')->get();

    	$list = [];

    	foreach($templateSets as $set) {

    		$template = \App\Models\Template::where('sid', $set->id)->where('elementMarked', '0')->first();

    		if(! is_null($template)) {
	    		$list[] = [
					'id' => $template->id,
					'ts_id' => $set->id,
					'title' => $set->title,
					'url_slug' => isSet($set->url_slug) ? $set->url_slug : ''
				];
    		}
    	}

    	return $list;
    }
}
