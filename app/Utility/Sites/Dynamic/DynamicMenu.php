<?php
	namespace App\Utility\Sites\Dynamic;

	use App\Utility\Sites\Dynamic\KH_MenuParser;
    use App\Utility\Sites\DynamicHeaderFooter;
    use App\Utility\Sites\Editor\LagacyMenu;
    use App\Models\MenuSiteInfo;


	class DynamicMenu
	{
		var $includefolder = 'include';
		var $menu_file = 'menu.html';
		var $menu_place_holder = '<menu_place_holder></menu_place_holder>';
		var $menu_place_holder_hide = '<menu_place_holder_hide></menu_place_holder_hide>';
		var $menu_place_holder_pattern = '%<menu_place_holder(?:_hide)?></menu_place_holder(?:_hide)?>%si';
		var $site = null;
		var $pageInjectionRegex = array(
			'%(<div[^>]*(?:id[\s]*=["|\']?body-fixed["|\']?)[^>]*>[\s]*<div[^>]*(?:class[\s]*=[\s]*["|\']?content-inner)[^>]*>[\s]*(?:<shared_fixed_place_holder></shared_fixed_place_holder>)?)%si',
			'%(<body[^>]*>[\s]*(?:<center[^>]*>)?[\s]*<div[^>]*(?:align[\s]*=["|\']?left["|\']?)[^>]*>)%si'
		);
		var $limit = 100;
		public $storage = null;

		private $menu_zIndex = 2147483647; // Maximum zIndex value for Menu. We need to show the menu on top of everything.

		function __construct($site=null)
		{
			$this->menu_file = $this->includefolder. '/' .$this->menu_file;
			$this->site = $site;
		}

		function get_html_with_menu($folder, $html, $file, $fromEditor=false,$storage)
		{

		    $this->storage = $storage;
			//$stylesheet = preg_replace('/\.html$/','.css',strtolower($file));
			//$stylesheet = (file_exists($folder."css/$stylesheet")) ? TRUE : FALSE;
			$stylesheet = false;

			$MenuParser = new KH_MenuParser($folder,$storage);
			$menu_html = $MenuParser->get_menuhtml();
			if ($menu_html !== false) { // $menu_html will be "false" if there's no menu.json file
				if (preg_match('%'.$this->menu_place_holder.'%si', $html)) {

					if ($stylesheet) {
						$menu_html = preg_replace('/style=\"([^"]*)\"/','class="menu_container"',$menu_html);
					}

					$html = str_replace($this->menu_place_holder, $menu_html, $html);
				} else {
					$html = str_replace($this->menu_place_holder_hide, '', $html);
				}
				return $html;
			}

			// Below code is all for old case, when we had menu html in a file include/menu.html and NOT in menu.json form.
			// I left this code here just to support legacy case for sometime. Once the json menu runs perfectly and each and every client
			// gets json based menu, then feel free to remove the below code :)
			if( $this->storage->fileExists($this->menu_file) ) {
				if (preg_match('%'.$this->menu_place_holder.'%si', $html)) {
					$menu_html = $this->storage->readPage($this->menu_file);

					if ($stylesheet) {
						$menu_html = preg_replace('/style=\"([^"]*)\"/','class="menu_container"',$menu_html);
					}

					$html = str_replace($this->menu_place_holder, $menu_html, $html);
				} else {
					$html = str_replace($this->menu_place_holder_hide, '', $html);
				}
				return $html;
			} else {
				return $html;
			}
		}

		function get_html_without_menu($html)
		{
			$html = preg_replace('%<div[^>]*objtype[\s]*=[\s]*[\'|"]?6[\'|"]?[^>]*>[\s]*(?:<!--assets-->.*?<!--assets-->)?[\s]*<div[^>]*>.*?</div>[\s]*</div>%si', $this->menu_place_holder, $html);
			return $html;
		}

		function replace_menu_with_placeholder($html)
		{
			return $this->get_html_without_menu($html);
		}

		function addMenu($pagename)
		{
			// Checking if menu is not in header and footer.
			$dynamicHeaderFooter = new DynamicHeaderFooter($this->site->storage());
			if( $dynamicHeaderFooter->isMenuInHeaderFooter($this->menu_place_holder_pattern) ){
				//error_log( $pagename . " menu on header can't add menu on page." );
				return false;
			}

			$page_html = $this->site->storage()->readPage($pagename);

			if ( !preg_match($this->menu_place_holder_pattern, $page_html) ) {
				$page_html = preg_replace($this->pageInjectionRegex, "$1\n".$this->menu_place_holder, $page_html);
			} else {
				$page_html = str_replace($this->menu_place_holder_hide, $this->menu_place_holder, $page_html);
			}

            $this->site->storage()->writePage($pagename, $page_html);
		}

		function deleteMenu($pagename)
		{
			$page_html = $this->site->storage()->readPage($pagename);

			if ( !preg_match($this->menu_place_holder_pattern, $page_html) ) {
				$page_html = preg_replace($this->pageInjectionRegex, "$1\n".$this->menu_place_holder_hide, $page_html);
			} else {
				$page_html = str_replace($this->menu_place_holder, $this->menu_place_holder_hide, $page_html);
			}

            $this->site->storage()->writePage($pagename, $page_html);
		}

		function show_hide_menu_from_pages($site, $action='addMenu')
		{
			$this->site = $site;
			$menu = MenusSiteInfo::where("siteid", $this->site->id)->orderBy('id', 'desc')->first();

			if(!is_null($menu)) {
				$menuid = $menu->id;

				$menuPages = DB::table('menu_template_selection')
		            ->where("siteid", $this->site->id)
		            ->where("menuid", $menuid)
		            ->where("hide_show", "show")
		            ->orderBy('id')
		            ->get();

		        foreach($menuPages as $menuPage) {
		        	$this->{$action}($menuPages->name);
		        }
			}
		}

		/*function show_hide_menu_from_pages($site, $action='addMenu')
		{

			$this->site = $site;

			$kh_menu = new KH_Menu($this->site->userid, $this->site->id);

			if( $kh_menu->selectOne('siteid', $this->site->id) ){
				$sql = "SELECT `name` FROM `pages` WHERE `siteid` = '".cleanInput($this->site->id)."' AND `showMenu` = '1' order by `id` ASC";
			} else {
				$sql = "SELECT `page_name` as name FROM `menu_template_selection` WHERE `site_id` = '".cleanInput($this->site->id)."' AND `hide_show` = 'show' order by `id` ASC";
			}

			$rs = queryContinueOnError($sql);

			if( $rs && mysqli_num_rows($rs) < $this->limit ) {
				while($row = mysqli_fetch_assoc($rs)) {
					$this->$action($row['name']);
				}
			} else {
				$params = array('pages'=>array());

				while($row = mysqli_fetch_assoc($rs)) {
					$params['pages'][] = $row['name'];
				}

				$this->post_params( $action, $params );
			}
		}

		function post_params( $action, $params ) {
			$url = uriInApp("library/services/updateMenuInBackground.php");

			$post = array(
				'SESSION' => $_SESSION,
				'COOKIE' => $_COOKIE,
				'DynamicMenu' => serialize($this),
				'params' => $params
			);

			$array = json_encode( $post, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
			curl_post_async($url, 'w='.base64_encode($array)."&action=".$action );
		}*/

		function clean_menu_assets($html)
		{
			$html = preg_replace('%<link[^>]*(?:custom_menu_css|drop_down_css)[^>]*>%si', '', $html);
			$html = preg_replace('%<script[^>]*(?:drop_down_script)[^>]*>[/s]*</script>%si', '', $html);

			return $html;
		}

		function read_page($file)
		{
		    $cs = new CommonStorage();
			return $cs->readPage($file);
		}

		function write_page($file, $html_content)
		{
            $cs = new CommonStorage();
			return $cs->writePage($file, $html_content);
		}

		function getMenuHTML()
		{
			if($this->site)
			{
				$menuInfo = MenusSiteInfo::where("siteid", $this->site->id)->orderBy('id', 'desc')->first();

				if(!is_null($menuInfo)) {

					$menuid = $menuInfo->id;
					$menu_template_id = 2;
					$menu_style_id = 52;

					$menuTemplate = DB::table('menu_template_selection')
			            ->where("siteid", $this->site->id)
			            ->where("menuid", $menuid)
			            ->first();

			        if(!is_null($menuTemplate)) {
			        	$menu_template_id = $menuTemplate->menu_template_id;
			        	$menu_style_id = $menuTemplate->menu_style_id;
			        }

			        $menuStyle = DB::table('menu_template_styles')
			            ->where("id", $menu_style_id)
			            ->where("menu_template_id", $menu_template_id)
			            ->where("status", "enabled")
			            ->first();

			        $site = $this->site;
			        $getMenuInnerHTML  = function($parentId) use ($menuid, $site, $menuStyle) {

			        	// Get pages of level
			        	$items = DB::table('menu_category')
				            ->where("site_menu_id", $menuid)
				            ->where("status", "enabled")
				            ->where("parent_id", $parentId)
				            ->orderBy('place_order')
				            ->get();

				        if(count($items) == 0) {
				        	return '';
				        }

				        $html = '';
				        $spacing = "\r\n\t";

				        if($parentId > 0) {
				        	$align = $menuStyle->menuAlign == 1 ? 'horizontal' : 'vertical';
				        	$html .= $spacing.'<span class="overload-'.$align.'"></span>'.$spacing.'<ul>'.$spacing;
				        }

				        foreach($items as $item) {
				        	$html .= '<li><a href="'.$item->link.'" target="'.$item->target.'">'.$item->title.'</a>';
				        	$html .= $getMenuInnerHTML($item->id);
				        	$html .= '</li>'.$spacing;
				        }

				        if($parentId > 0) {
				        	$html .= '</ul>'.$spacing.'</span>'.$spacing;
				        }

				        return $html;
					};

			        $menu_resouce_path = 'https://static.secure.website/library/menus/';
			        $menu_css_file = $menu_resouce_path . $menuStyle['css_path'];
			        $menu_js_file = $menu_resouce_path . $menuStyle['js_path'];

					$menuDiv = '<div id="mymenu_'.$menuid.'" ' . $menuInfo->style_tag . ' objtype="6">'."\r\n\t";
					$menuDiv .= '<!--assets-->'."\r\n\t";
					$menuDiv .= '<link id="drop_down_scriptwn_css" rel="stylesheet" type="text/css" href="'.$menu_css_file.'"/>'."\r\n\t";
					$menuDiv .= '<link id="drop_down_css" rel="stylesheet" type="text/css" href="css/rollOverEffect.css?r='.str_random(12).'"/>'."\r\n\t";
					$menuDiv .= '<script id="drop_down_script" type="text/javascript" src="'.$menu_js_file.'"></script>'."\r\n\t";
					$menuDiv .= '<!--assets-->'."\r\n\t";
					$menuDiv .= '<div class="suckertreemenu">'."\r\n\t";
					$menuDiv .= '<ul id="treemenu1" isVertical="'.$menuStyle->menuAlign.'">'."\r\n\t";
					$menuDiv .= $getMenuInnerHTML(0);
					$menuDiv .= '</ul>'."\r\n\t";
					$menuDiv .= '</div>'."\r\n";
					$menuDiv .= '</div>'."\r\n";
					return $menuDiv;
				}
			}

			return false;
		}

		/**
		 * This function writes the menu content in include/menu.html file.
		 * It first takes the content from DB->table, then simply overwrites in include/menu.html file.
		 */
		function reCreateMenu()
		{
			if ($this->site) {

				$menuhtml = $this->getMenuHTML();

				if($menuhtml) {
					$retVal = $this->site->storage()->writePage($this->menu_file, $menuhtml);
					return $retVal;
				}
			}

			return false;
		}

		function changeMenuStyle($newStyle)
		{

			$menu_html = $this->site->storage()->readPage($this->menu_file);
			//$this->menu_zIndex = 2147483647;
			//$newStyle = preg_replace('/z-index[\s]*:[\s]*[^;]*;/si', 'z-index:2147483647;', $newStyle);

			$retVal = false;
			if (preg_match('/<div[^>]*(?:objtype[\s]*=[\s]*["|\']?6["|\']?)[^>]*>/i', $menu_html, $regs_main_div)) {
				if (preg_match('/<div[^>]*style[\s]*=[\s]*["|\']?([^"\']*)[^>]*>/si', $regs_main_div[0], $regs_main_div_style)) {
					$menu_html = str_replace($regs_main_div_style[1], $newStyle, $menu_html);
					$retVal = $this->site->storage()->writePage($this->menu_file, $menu_html);
				}
			}
			return $retVal;
		}

		function getMenuStyleFromPage($pagename="index.html")
		{

			$page_html = $this->site->storage()->readPage($pagename);

			if( preg_match('/<div[^>]*(?:objtype[\s]*=[\s]*["|\']?6["|\']?)[^>]*>/si', $page_html, $regs_main_div) ) {
				if( preg_match('/<div[^>]*style[\s]*=[\s]*["|\']?([^"\']*)[^>]*>/si', $regs_main_div[0], $regs_main_div_style) ) {
					return $regs_main_div_style[1];
				}
			}
			return false;
		}

		function saveMenuStyleFromPage($site)
		{
			$this->site = $site;
			if( $this->site->id > 0 ) {
				$menuStyle = $this->getMenuStyleFromPage();

				$menuSiteInfo = MenusSiteInfo::where("siteid", $this->site->id)->orderBy('id', 'desc')->first();

				if( isset($menuStyle) && $menuStyle != "" && $menuStyle!==FALSE && !is_null($menuSiteInfo) ) {
					if( $menuSiteInfo->style_tag != $menuStyle ) {
						$menuSiteInfo->style_tag = 'style="'.$menuStyle.'"';
						$menuSiteInfo->save();
					}
				}
			}
		}

		function fixMenuEntries($site) {

			$this->site = $site;

			$menuSiteInfo = MenusSiteInfo::where("siteid", $this->site->id)->orderBy('id', 'desc')->first();
			if( !is_null($menuSiteInfo) ) {
				$menu_id = $menuSiteInfo->id;
			}

			if( isset($menu_id) && !empty($menu_id) && is_numeric($menu_id) )
			{
				/*requireOnceInApp("objects/newPagingDashboard.php");
				$paging = new PagingDashboard($this->site->id, $menu_id, '', 1, false);
				$paging->checkPagesUpdated();*/
				return true;
			}

		}

		function makeStaticPages($folder,$is_template=false){

			$menu_asset_pattren = '/<!--assets-->(.*?)<!--assets-->/si';
			if(!$is_template) {
                $menu_content = $this->site->storage()->readPage($this->menu_file);
                //$folder = see @todo above;
            } else {
                requireOnceInApp("objects/CommonStorage.php");
                $cs = new CommonStorage();
                $menu_content = $cs->readPage($folder.$this->menu_file);
            }

			$menu_asset = '';
			if (preg_match($menu_asset_pattren, $menu_content, $regs)) {
				$menu_asset = str_replace('<!--assets-->', '', $regs[0]);
			}
			$menu_content = preg_replace($menu_asset_pattren, '', $menu_content);

            if(!$is_template) {
                $files = $this->site->storage()->getFileListSite("",["file"]);
                foreach($files as $file) {
                    if( preg_match('/\.html/si', $file) ) {

                        $content = $this->site->storage()->readPage($file);
                        $pattern_show = '%<menu_place_holder></menu_place_holder>%si';
                        $pattern_hide = '%<menu_place_holder_hide></menu_place_holder_hide>%si';

                        if (preg_match($pattern_hide, $content)) {
                            $content = preg_replace($pattern_hide, '', $content);
                        } else if (preg_match($pattern_show, $content)) {
                            $content = preg_replace('%<\/head>%si', "\n".$menu_asset.'</head>', $content);
                            $content = preg_replace($pattern_show, $menu_content, $content);
                        }

                        $this->site->storage()->writePage($file, $content);
                    }
                }
            } else {
                $files = $cs->getFileList($folder,["file"]);
                foreach($files as $file) {
                    if( preg_match('/\.html/si', $file) ) {

                        $content = $cs->readPage($folder.$file);
                        $pattern_show = '%<menu_place_holder></menu_place_holder>%si';
                        $pattern_hide = '%<menu_place_holder_hide></menu_place_holder_hide>%si';

                        if (preg_match($pattern_hide, $content)) {
                            $content = preg_replace($pattern_hide, '', $content);
                        } else if (preg_match($pattern_show, $content)) {
                            $content = preg_replace('%<\/head>%si', "\n".$menu_asset.'</head>', $content);
                            $content = preg_replace($pattern_show, $menu_content, $content);
                        }

                        $cs->writePage($folder.$file, $content);
                    }
                }
            }

		}

		/**
		 * This function writes the menu content in include/menu.html file.
		 * It first takes the content from DB->table, then simply overwrites in include/menu.html file.
		 */
		function updateCustomCSSURL()
		{
			if ($this->site) {

				$menu_content = $this->site->storage()->readPage($this->menu_file);

				$result = preg_match('%<link[^>]*href[\s]*=[\s]*["|\']?(css/rollOverEffect\.css(?:\?(?:rand|r)=[\d.]*)?)["|\']?[^>]*>%i', $menu_content);
				if ($result) {
					$link = "css/rollOverEffect.css?r=".timeStamp();
					$menu_content = str_replace($result[1], $link, $menu_content);
				}

				$retVal = $this->site->storage()->writePage($this->menu_file, $menu_content);
				return $retVal;
			} else {
				return false;
			}
		}

		/*function attributeTag_strToAssoc($str)
		{

		}

		function attributeTag_assocToStr()
		{

		}*/
	}
?>
