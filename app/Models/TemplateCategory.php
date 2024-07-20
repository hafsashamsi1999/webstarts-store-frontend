<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 11 Oct 2019 18:04:47 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TemplateCategory
 * 
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int $sort_order
 * @property bool $status
 *
 * @package App\Models
 */
class TemplateCategory extends Model
{
	public $timestamps = false;

	protected $casts = [
		'parent_id' => 'int',
		'sort_order' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'parent_id',
		'sort_order',
		'status'
	];

	public static function getNewCategories()
	{
		$categories = TemplateCategory::where('status', '2')->orderBy('sort_order', 'asc')->get()->toArray();
		$parents = self::filterArrayByValue($categories, '0');

		$data = [];

        foreach($parents as $parent) {

            $cat = ['id' => $parent['id'], 'name' => $parent['name'], 'sub' => []];

            $children = self::filterArrayByValue($categories, $parent['id']);
            foreach($children as $child) {
                $cat['sub'][] = ['id' => $child['id'], 'name' => $child['name']];
            }

            $data[] = $cat;
        }

        return $data;
	}

    public static function filterArrayByValue($categories, $filterBy)
    {
        return array_filter($categories, function ($var) use ($filterBy) {
            return ($var['parent_id'] == $filterBy);
        });
    }
}
