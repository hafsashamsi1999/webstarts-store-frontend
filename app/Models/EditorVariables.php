<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 22 Oct 2019 19:49:50 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EditorVariables
 *
 * @property int $id
 * @property int $userid
 * @property int $siteid
 * @property array $arrCustomColor
 * @property array $arrCustomGradients
 * @property array $arrClipBoard
 * @property array $arrGoogleFonts
 * @property bool $guidelines_state
 * @property bool $ruler_state
 * @property bool $featuredTools_state
 * @property object $defaultcss
 * @property object $extraInfo
 * @property bool $is_dynamic
 * @property bool $doctype
 * @property bool $reset_css
 * @property \Carbon\Carbon $timestamp
 * @property bool $header_alert
 * @property bool $borders_state
 * @property bool $posData_state
 * @property bool $html_structure
 * @property int $dynamic
 *
 * @package App\Models
 */
class EditorVariables extends Eloquent
{
	protected $table = 'editorVariables';
	public $timestamps = false;
	public $defaultValues;

	protected $casts = [
		'userid' => 'int',
		'siteid' => 'int',
		'guidelines_state' => 'boolean',
		'ruler_state' => 'boolean',
		'featuredTools_state' => 'boolean',
		'is_dynamic' => 'boolean',
		'doctype' => 'boolean',
		'reset_css' => 'boolean',
		'header_alert' => 'boolean',
		'borders_state' => 'boolean',
		'posData_state' => 'boolean',
		'html_structure' => 'boolean',
		'dynamic' => 'boolean',
		'arrGoogleFonts' => 'object',
		'arrCustomColor' => 'object',
		'arrCustomGradients' => 'object',
		'arrClipBoard' => 'object',
		'extraInfo' => 'object',
		'defaultcss' => 'object'
	];

	protected $dates = [
		'timestamp'
	];

	/*protected $fillable = [
		'userid',
		'siteid',
		'guidelines_state',
		'ruler_state',
		'featuredTools_state',
		'is_dynamic',
		'doctype',
		'reset_css',
		'timestamp',
		'header_alert',
		'borders_state',
		'posData_state',
		'html_structure',
		'dynamic',
		'arrGoogleFonts',
		'arrCustomColor',
		'arrCustomGradients',
		'arrClipBoard',
		'defaultcss',
		'extraInfo'
	];*/

    protected $guarded = [];

    public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class, 'siteid');
    }

    public static function getDefaults()
    {
    	$getGradientItem = function($name, $rule, $direction, $colors)
    	{
            return ["name" => $name, "rule" => $rule, "direction" => $direction, "colors" => $colors];
    	};

        $return = [
            "arrCustomColor" => [],
            "arrCustomGradients" => [
                $getGradientItem("Skyline", "linear-gradient(to bottom, #1488CC, #2B32B2)", "bottom", "#1488CC,#2B32B2"),
                $getGradientItem("Playing with Reds", "linear-gradient(to bottom, #D31027, #EA384D)", "bottom", "#D31027,#EA384D"),
                $getGradientItem("Rose Water", "linear-gradient(to bottom, #E55D87, #5FC3E4)", "bottom", "#E55D87,#5FC3E4"),
                $getGradientItem("Kashmir", "linear-gradient(to bottom, #614385, #516395)", "bottom", "#614385,#516395"),
                $getGradientItem("Midnight City", "linear-gradient(to bottom, #232526, #414345)", "bottom", "#232526,#414345"),
                $getGradientItem("Clouds", "linear-gradient(to bottom, #ECE9E6, #FFFFFF)", "bottom", "#ECE9E6,#FFFFFF"),
                $getGradientItem("Calm Darya", "linear-gradient(to bottom, #5f2c82, #49a09d)", "bottom", "#5f2c82,#49a09d"),
                $getGradientItem("Blush", "linear-gradient(to bottom, #B24592, #F15F79)", "bottom", "#B24592,#F15F79"),
                $getGradientItem("Inbox", "linear-gradient(to bottom, #457fca, #5691c8)", "bottom", "#457fca,#5691c8"),
                $getGradientItem("EasyMed", "linear-gradient(to bottom, #DCE35B, #45B649)", "bottom", "#DCE35B,#45B649"),
                $getGradientItem("Can You Feel The Love Tonight", "linear-gradient(to bottom, #4568DC, #B06AB3)", "bottom", "#4568DC,#B06AB3"),
                $getGradientItem("Sunkist", "linear-gradient(to bottom, #F2994A, #F2C94C)", "bottom", "#F2994A,#F2C94C"),
                $getGradientItem("Blue Skies", "linear-gradient(to bottom, #56CCF2, #2F80ED)", "bottom", "#1488CC,#2F80ED")
            ],
            "arrGoogleFonts" => ["Lobster","Kaushan Script","Mystery Quest","Crafty Girls","Unkempt"],
            "arrClipBoard" => [],
            "guidelines_state" => true,
            "featuredTools_state" => true,
            "ruler_state" => false,
            "is_dynamic" => true,
            "doctype" => false,
            "reset_css" => false,
            "borders_state" => true,
            "posData_state" => false,
            "html_structure" => true,
            "dynamic" => true,
            "header_alert" => false,
            "defaultcss" => [],
            "extraInfo" => []
        ];

        return $return;
    }
}
