<?php

	namespace App\Utility\Sites\Dynamic;

	class KH_MenuParser
	{
		private $includefolder = 'include';
		private $menu_file = 'menu.json';
		private $user_sitefolder_path = '';
		private $endTagStack = array();  // We will use this stack to hold html element's ending/closing tags because the code isn't a recursive logic.
		private $isVertical = '0';  // Default Menu Orientation is Horizontal
        public $storage;
		public $kh_menu = array();
		//public $site = null;


		function __construct($sitePath='',$storage=null)
		{
			$this->menu_file = $this->includefolder. '/' .$this->menu_file;
			if ($sitePath != '') {
				$this->user_sitefolder_path = $sitePath;
			}
			$this->storage = $storage;


		}

		private function getMenuOverloadCSSClass(){
			return ($this->isVertical == '0')?'overload-horizontal':'overload-vertical';
		}
		public function read_JsonMenu(){
			if ($this->storage->fileExists($this->menu_file)) {
				return $this->storage->readPage($this->menu_file);
			}
			return false;
		}
        public function read_JsonMenuWithSiteStorage(){
            if ($this->storage->fileExists($this->menu_file)) {
                return $this->storage->readPage($this->menu_file);
            }
            return false;
        }
		public function write_JsonMenu($json_content){
			if ($this->user_sitefolder_path == '') {
				return false;
			}
			return $this->storage->writePage($this->menu_file, $json_content);
		}

        public function write_JsonMenuWithSiteStorage($json_content){
            return $this->storage->writePage($this->menu_file, $json_content);
        }

		public function isMenuJsonExists(){
			if( $this->storage->fileExists($this->menu_file) ) {
				return true;
			} else {
				return false;
			}
		}

		public function get_menuhtml($jsonString=''){
			$tabs = "\t";
			$menu_html = '';
			if ($jsonString == '') {
			    if(!empty($this->storage)) {
                    if ( ($jsonString=$this->read_JsonMenuWithSiteStorage()) === false) {
                        return false;
                    }
                } else {
                    if ($this->user_sitefolder_path != '') {
                        if ( ($jsonString=$this->read_JsonMenu()) === false) {
                            return false;
                        }
                    }
                }
			}

			// Start parsing json string into HTML
			$this->kh_menu = json_decode($jsonString, true); // 'true' for associative array
			//printArray($this->kh_menu);

			// Generate container's starting tag and push it's ending tag in endTagStack
			$menu_html .= $this->processHtmlTag($this->kh_menu['MenuContainer']);
			array_push($this->endTagStack, '</'.$this->kh_menu['MenuContainer']['nodeName'].'>');

			$menu_html .= '<!--assets-->'."\n";
			// Generate container's links
			if ( is_array($this->kh_menu['MenuContainer']['links']) ) {
				foreach ($this->kh_menu['MenuContainer']['links'] as $linknode) {
					$menu_html .= $this->processHtmlTag($linknode);
				}
			}
			// Generate container's scripts
			if ( is_array($this->kh_menu['MenuContainer']['scripts']) ) {
				foreach ($this->kh_menu['MenuContainer']['scripts'] as $scriptnode) {
					$menu_html .= $this->processHtmlTag($scriptnode,true);
				}
			}
			$menu_html .= '<!--assets-->'."\n";

			// Generate container's MenuDiv 'THE suckertreemenu':) and push it's ending tag in endTagStack
			$menu_html .= $this->processHtmlTag($this->kh_menu['MenuContainer']['menu']);
			array_push($this->endTagStack, "</".$this->kh_menu['MenuContainer']['menu']['nodeName'].">\n"); // This is </DIV>

			// Generate initial menuItem i.e. initial UL tag 'treemenu1' tag and push it's ending tag in endTagStack
			$menu_html .= $tabs. $this->processHtmlTag($this->kh_menu['MenuContainer']['menu']['menuitem']);
			array_push($this->endTagStack, $tabs. "</".$this->kh_menu['MenuContainer']['menu']['menuitem']['nodeName'].">\n"); // This is </UL>
			// Check the Menu Orientation which is written in attribute of first main UL
			$this->isVertical = $this->kh_menu['MenuContainer']['menu']['menuitem']['attributes']['isVertical'];

			// Generate actual links now with ul->li chain
			$menu_html .= $this->processChildNodes($this->kh_menu['MenuContainer']['menu']['menuitem']['menuitems']);
			//printArray($this->endTagStack);

			// All Done, pop all the pushed end tags (i.e. 2 parent DIVs)
			/*for ($i=0; $i < count($this->endTagStack); $i++) {
				$menu_html .= array_pop($this->endTagStack);
			}*/
			$menu_html .= array_pop($this->endTagStack);
			$menu_html .= array_pop($this->endTagStack);
			//printArray($this->endTagStack);
			return $menu_html;
		}

		private function processChildNodes($nodes, $level=0){
			$innerHTML = '';

			$tabs = "\t";
			for($i=0;$i<$level+1;$i++){
				$tabs .= "\t";
			}

			foreach ($nodes as $node) {
				$innerHTML .= $tabs. '<li>'. $this->processHtmlTag($node,false,false). $node['nodeText']. '</'.$node['nodeName'].'>';

				// If node has childs, then recursive call the function
				if (isset($node['menuitem']) && is_array($node['menuitem']['menuitems']) && count($node['menuitem']['menuitems'])>0) {
					array_push($this->endTagStack, "</li>\n");

					if($level>0){
						$overloadCSSClass = 'overload-vertical';
					}else{
						$overloadCSSClass = $this->getMenuOverloadCSSClass();
					}

					$innerHTML .= "<span class=\"".$overloadCSSClass."\">&nbsp;</span>\n";
					$innerHTML .= $tabs. "<ul>\n";
					array_push($this->endTagStack, $tabs."</ul>\n"); // Inner UL i.e. Level-1 UL
					$innerHTML .= $this->processChildNodes($node['menuitem']['menuitems'], $level+1); // Recursive Call to create child pages ul-li list
					$innerHTML .= $tabs. array_pop($this->endTagStack); // POP the recent li end tag
				} else {
					$innerHTML .= "</li>\n";
				}
			}
			// Close the end tag of the last parent element
			$innerHTML .= array_pop($this->endTagStack); // POP the recent ul end tag
			return $innerHTML;
		}

		// Create html tag. It will only make the tag Start and it's attributes.
		private function processHtmlTag($node, $withEndTag=false, $useLineBreaks=true){
			$tagString = '<'.$node['nodeName'];
			// Generate container's attributes
			$attributes = $node['attributes'];
			if ( is_array($attributes) ) {
				foreach ($attributes as $key => $value) {
					$tagString .= ' '.strtolower($key).'=';
					if (gettype($value) == 'string') {
						$tagString .= '"'.$value.'"';
					} else if (is_array($value) && strtolower($key) == 'style') {	// If this is a style attribute
						$tagString .= '"'.$this->processStyle($value).'"';
					}
				}
			}
			if ($withEndTag) {
				$tagString .= "></".$node['nodeName'].">\n";
			} else {
				if ($useLineBreaks) {
					$tagString .= ">\n";
				}else{
					$tagString .= ">";
				}
			}
			return $tagString;
		}
		// Create style attributes
		private function processStyle($styleAttributes){
			$styleString = '';
			foreach ($styleAttributes as $key => $value) {
				$styleString .= strtolower($key).':'.$value.';';
			}
			return $styleString;
		}
	}

?>
