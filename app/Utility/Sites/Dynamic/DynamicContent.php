<?php

	namespace App\Utility\Sites\Dynamic;

	/* read_page and get_updated_html (along with their chain of functions) is called from
	 * webstarts client site render.php file. Everything in that chain will not be compatible
	 * with SiteStorage in webstarts codebase
	 */

	class DynamicContent
	{
		/**
			If we create more dynamic content in future, we will put entry in this variable.
		**/
		var $contents = array(
			'headCommon'	=> array(
								'class'=>'\App\Utility\Sites\Dynamic\DynamicHead',
								'method'=>'get_html_with_common_head',
								'place_holder'=>'<head>'
							),
			'topbar'		=> array(
								'class'=>'\App\Utility\Sites\Dynamic\DynamicHeaderFooter',
								'method'=>'get_html_with_topbar',
								'place_holder'=>'<topbar_place_holder></topbar_place_holder>'
							),
			'header'		=> array(
								'class'=>'\App\Utility\Sites\Dynamic\DynamicHeaderFooter',
								'method'=>'get_html_with_header',
								'place_holder'=>'<header_place_holder></header_place_holder>'
							),
			'footer'		=> array(
								'class'=>'\App\Utility\Sites\Dynamic\DynamicHeaderFooter',
								'method'=>'get_html_with_footer',
								'place_holder'=>'<footer_place_holder></footer_place_holder>'
							),
			'menu'			=> array(
								'class'=>'\App\Utility\Sites\Dynamic\DynamicMenu',
								'method'=>'get_html_with_menu',
								'place_holder'=>'<menu_place_holder></menu_place_holder>'
							),
			'nomenu'		=> array(
								'class'=>'\App\Utility\Sites\Dynamic\DynamicMenu',
								'method'=>'get_html_with_menu',
								'place_holder'=>'<menu_place_holder_hide></menu_place_holder_hide>'
							),
			'sharedFull'	=> array(
								'class'=>'\App\Utility\Sites\Dynamic\DynamicSharedContents',
								'method'=>'get_full_shared_content',
								'place_holder'=>'<shared_full_place_holder></shared_full_place_holder>'
							),
			'sharedFixed'	=> array(
								'class'=>'\App\Utility\Sites\Dynamic\DynamicSharedContents',
								'method'=>'get_fixed_shared_content',
								'place_holder'=>'<shared_fixed_place_holder></shared_fixed_place_holder>'
							)
		);

		public $replacements = array(
			// Webstarts resources
			'http://static.secure.website',
			'http://static.webstarts.com',
			'http://stats.webstarts.com',
			'http://embed.apps.webstarts.com',
			'http://css.blog.plugins.editor.apps.webstarts.com',
			'http://js.blog.plugins.editor.apps.webstarts.com',
			'http://form.plugins.editor.apps.webstarts.com',
			'http://js.form.plugins.editor.apps.webstarts.com',
			'http://css.form.plugins.editor.apps.webstarts.com',
			'http://www.webstarts.com',
			'http://webstarts.com',
			'http://www.webstartsshoppingcart.com',
			'http://webstartsshoppingcart.com',
			'http://photogallery.plugins.editor.apps.webstarts.com',
			'http://js.cdn.webstarts.com',
			'http://css.cdn.webstarts.com',
			'http://css.guestbook.plugins.editor.apps.webstarts.com',
			'http://guestbook.plugins.editor.apps.webstarts.com',
			'http://product.plugins.ecommerce.apps.webstarts.com',

			// Approved external resources
			'http://www.youtube.com',
			'http://fonts.googleapis.com',
			'http://connect.facebook.net',
			'http://passets-cdn.pinterest.com',
			'http://badge.facebook.com',
			'http://www.facebook.com',
			'http://www.google.com',
			'http://platform.twitter.com',
			'http://player.vimeo.com',
			'http://www.angieslist.com',
			'http://pagead2.googlesyndication.com',
			'http://maps.google.com',
			'http://code.jquery.com',
		);

		function __construct()
		{
			$this->isDynamicRouting = isset($_GET['dynamicRouting']) ? $_GET['dynamicRouting'] : false;
			$this->numFolders = 0;

			if($this->isDynamicRouting) {
				if(isset($_GET['ws_prop_dynamic_folder_count'])) {
					$this->numFolders = intval($_GET['ws_prop_dynamic_folder_count']) - 1;
				} else {
					$this->numFolders = substr_count($_SERVER['REDIRECT_URL'], '/') - 1;
				}
			}
		}

		public function adjust_relative_urls($html)
		{
			if($this->numFolders === 0) return $html;

			$adjustment = '';
			for($i = 0; $i < $this->numFolders; $i++)
			{
				$adjustment .= '../';
			}

			/* Adapted from objects/Sites.php
			 * Site::getPageHTML_WYSIWYG
			 */
			$html = str_ireplace('href="css/','href="'.$adjustment.'css/', $html);
			$html = str_ireplace('="images/','="'.$adjustment.'images/', $html);
			$html = str_ireplace('="uploads/','="'.$adjustment.'uploads/', $html);
			$html = str_ireplace('file=uploads/','file='.$adjustment.'uploads/', $html);
			$html = str_ireplace('url(uploads/','url('.$adjustment.'uploads/', $html);
			$html = str_ireplace('href="blog','href="'.$adjustment.'blog', $html);
			$html = str_ireplace('href="store','href="'.$adjustment.'store', $html);

			// Modified above regex to handle anchor links
			preg_match_all('/href[\s]*=[\s]*["|\']?([\w\d-]+\.html[\w\d-#]*)["|\']?/i', $html, $bodyArr);
			for( $i=0; $i<count($bodyArr[0]); $i++ )
			{
				if( !empty($bodyArr[0][$i]) && (strpos($bodyArr[0][$i], "http://") === false) )
					$html = str_ireplace( $bodyArr[0][$i], 'href="'.$adjustment.$bodyArr[1][$i].'"', $html);
			}

			return $html;
		}

		public function get_updated_html($folder, $html, $file='', $fromEditor=false, $storage=null)
		{
			if($this->isDynamicRouting) {
				$prerender = new PrerenderIO;
				if($prerender->shouldShowPrerenderedPage()) {
					return $prerender->getPrerenderedPageResponse();
				}
			}

			$class = '';

			foreach( $this->contents as $feature => $conf ) {
				if (preg_match('%'.$conf['place_holder'].'%si', $html)) {
					if($class != $conf['class']) {

						$class = $conf['class'];

						if($class == "DynamicMenu") {
							$contentClass = new $class();
						} else {
							$contentClass = new $class($storage);
						}
					}
					$html = $contentClass->{$conf['method']}($folder, $html, $file, $fromEditor, $storage);
				}
			}

			if (isSet($_SERVER['PREVIEW_VERSION'])){
				$html = preg_replace('/(https?:\/\/static\.secure\.website\/client-site-resources\/\d+\/)/i', '', $html);
			}

			if($this->isDynamicRouting)
			{
				$html = $this->adjust_relative_urls($html);
			}

			if($_SERVER["SERVER_PORT"] == 443) {
				foreach($this->replacements as $value) {
					$replacement = str_ireplace('http://', 'https://', $value);
					$html = str_ireplace($value, $replacement, $html);
				}
			}

			return $html;
		}

		public function read_page($file)
		{
			return file_get_contents($file);
		}

	}
