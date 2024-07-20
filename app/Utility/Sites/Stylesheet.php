<?php
namespace App\Utility\Sites;

use App\Models\Sites;

class Stylesheet {

	var $_loaded = FALSE;
	var $_css_string = FALSE;
	var $_folder = 'css/';
	var $_filename = FALSE;
	var $_http_path = FALSE;
	var $Site = FALSE;
	var $storage = FALSE;

	function __construct($siteid = FALSE, $file = FALSE)
	{
		if($siteid !== FALSE && $file !== FALSE)
		{
			$this->load($siteid, $file);
		}
	}

    function Stylesheet($siteid = FALSE, $file = FALSE)
    {
        self::__construct();
    }

	protected function load($siteid, $file)
	{
		$this->Site = Sites::where([["id", $siteid]])->first();

		if(!is_null($this->Site))
		{
			$this->storage = $this->Site->storage();

			$this->_filename = $file;
			$this->_http_path = $this->Site->getTitle('', false);

			$this->_loaded = TRUE;
		}
		else
		{
			throw new Exception("Error: Could not find site associated with this siteid");
		}
	}

	public static function setup_default_styles($siteid)
	{
		$site_css = new Stylesheet($siteid, 'site.css');
		$value = $site_css->get();
		if(empty($value))
		{
			$site_css->set(
				".content-fixed > .content-inner { margin:0 auto; }\n".
				".converted-page #body-fixed *, .converted-page #body-fixed *:before, .converted-page #body-fixed *:after { -ms-box-sizing: content-box; -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; }\n".
				".converted-page #body-fixed shared *, .converted-page #body-fixed shared *:before, .converted-page #body-fixed shared *:after { -ms-box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }\n".
				".converted-page #body-fixed .suckertreemenu, .converted-page #body-fixed div[objtype=\"6\"] { display: block; }"
			);
		}

		$layout_desktop_css = new Stylesheet($siteid, 'layout-desktop.css');
		$value = $layout_desktop_css->get();
		if(empty($value))
		{
			$layout_desktop_css->set(
				"/* Start Viewport desktop */\n".
				".content-full > .content-inner > [objtype], .content-full > .content-inner > shared > [objtype] { min-width:980px; }\n".
				".content-fixed > .content-inner { width:980px; }\n".
				".wse-men > nav { display:block; }\n".
				".wse-men .menu-toggle { display:none; }\n".
				"#body-content { min-height:350px; }\n".
				"/* End Viewport desktop */\n"
			);
		}
	}

	public function loaded()
	{
		return $this->_loaded;
	}

	public function get($options = [])
	{
		if( ! $this->_loaded)
			throw new Exception('Error: Stylesheet object must be loaded before css can be fetched');

		// Get the css string
		if($this->_css_string === false) {
			if($this->storage->fileExists($this->_folder . $this->_filename)) {
				$this->_css_string = $this->storage->readFile($this->_folder . $this->_filename);
			} else {
				$this->_css_string = '';
			}
		}

		$css = $this->_css_string;

		$css = str_ireplace('url(../uploads/','url(' . $this->_http_path . '/uploads/', $css);
		$css = str_ireplace('url(../images/','url('  . $this->_http_path . '/images/',  $css);
		$css = str_ireplace('url(../thumbs/','url('  . $this->_http_path . '/thumbs/',  $css);

		$this->_css_string = $css;

		return $this->_css_string;
	}

	public function set($css = "")
	{
		if( ! $this->_loaded)
			throw new Exception('Error: Stylesheet object must be loaded before css can be set');

		$css = str_ireplace('url(' . $this->_http_path . '/uploads/', 'url(../uploads/', $css);
		$css = str_ireplace('url(' . $this->_http_path . '/images/',  'url(../images/',  $css);
		$css = str_ireplace('url(' . $this->_http_path . '/thumbs/',  'url(../thumbs/',  $css);

		$this->_css_string = $css;

		$this->storage->writeFile(
			$this->_folder . $this->_filename,
			$this->_css_string
		);
	}

}
