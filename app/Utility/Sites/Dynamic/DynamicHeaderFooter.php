<?php

	namespace App\Utility\Sites\Dynamic;

	use App\Utility\Sites\SiteUtilities;
	use App\Utility\Sites\Storage\CommonStorage;
	use App\Utility\Sites\Dynamic\DynamicHead;
	use App\Utility\simple_html_dom;

	class DynamicHeaderFooter
	{
		public $style_id = 'header_footer_style';
        public $includefolder = 'include';
        public $header_file = 'header.html';
        public $footer_file = 'footer.html';
        public $topbar_file = 'topbar.html';
        public $css_file = 'css/header_footer.css';
        public $topbar_place_holder = '<topbar_place_holder></topbar_place_holder>';
        public $header_place_holder = '<header_place_holder></header_place_holder>';
        public $footer_place_holder = '<footer_place_holder></footer_place_holder>';
        public $topbar_pattern = '%<wsc-topbar>.*?</wsc-topbar>%si';
        public $header_pattern = '%<header>.*?</header>%si';
        public $footer_pattern = '%<footer>.*?</footer>%si';
        public $storage = null;

		function __construct($storage=null)
		{
			$this->topbar_file = $this->includefolder. '/' .$this->topbar_file;
			$this->header_file = $this->includefolder. '/' .$this->header_file;
			$this->footer_file = $this->includefolder. '/' .$this->footer_file;
			$this->storage = $storage;
		}

		function get($property)
		{
			if (array_key_exists($property, get_class_vars(get_class($this)))) {
				return $this->{$property};
			} else {
				throw new Exception("property not exist");
			}
		}

		function get_html_with_topbar($folder, $html, $file="", $fromEditor=false, $storage)
		{
            $this->storage = $storage;
			if (preg_match('%'.$this->topbar_place_holder.'%si', $html)) {

				if( $this->storage->fileExists($this->topbar_file) ) {
					$dynamic_html = $this->storage->readPage($this->topbar_file);
				} else {
					$dynamic_html = '';
				}

				$html = str_replace($this->topbar_place_holder, $dynamic_html, $html);
			}
			return $html;
		}

		function get_html_with_header($folder, $html, $file="", $fromEditor=false, $storage)
		{
            $this->storage = $storage;
			if (preg_match('%'.$this->header_place_holder.'%si', $html)) {

				if( $this->storage->fileExists($this->header_file) ) {
					$dynamic_html = $this->storage->readPage($this->header_file);
				} else {
					$dynamic_html = '';
				}

				$html = str_replace($this->header_place_holder, $dynamic_html, $html);
			}
			return $html;
		}

		function get_html_with_footer($folder, $html, $file="", $fromEditor=false,$storage)
		{
            $this->storage = $storage;
			if (preg_match('%'.$this->footer_place_holder.'%si', $html)) {

				if( $this->storage->fileExists($this->footer_file) ) {
					$dynamic_html = $this->storage->readPage($this->footer_file);
				} else {
					$dynamic_html = '';
				}

				$html = str_replace($this->footer_place_holder, $dynamic_html, $html);
			}
			return $html;

		}

		function isMenuInHeaderFooter($pattern)
		{
			$html = '';
			if( $this->storage->fileExists($this->header_file) ) {
				$html .= $this->storage->readPage($this->header_file);
			}

			if( $this->storage->fileExists($this->footer_file) ) {
				$html .= $this->storage->readPage($this->footer_file);
			}

			if (preg_match($pattern, $html)) {
				return true;
			}

			return false;
		}

		function getNodeHTML($html, $selector)
		{
			$dom = new simple_html_dom();
			$dom->load($html, true, false);

			$nodes = $dom->find("body > $selector");

			if(count($nodes) > 0) {
				return $nodes[0]->outertext();
			}

			return '';
		}

		function save_header_footer($html, $site = false)
		{
			$topbarHTML = '';
			$headerHTML = '';
			$footerHTML = '';

			if (preg_match($this->topbar_pattern, $html, $match))
			{
				$topbarHTML = $match[0];
			}

			preg_match_all($this->header_pattern, $html, $match);

			// First Header Matched
			if(!is_null($match) && is_array($match) && count($match) > 0) {
				if(is_array($match[0]) && count($match[0]) > 0) {
					$headerHTML = $match[0][0];
				}
			}

			preg_match_all($this->footer_pattern, $html, $match);

			// Last Footer Matched
			if(!is_null($match) && is_array($match) && count($match) > 0) {
				if(is_array($match[0]) && count($match[0]) > 0) {
					$footerHTML = $match[0][count($match)-1];
				}
			}

			if( $topbarHTML != '')
			{
				// Convert html to relative paths
				if($site !== false)
				{
					$topbarHTML = SiteUtilities::html_to_relative_path($topbarHTML, $site);
				}

				// Write topbar html to file
				$this->storage->writePage($this->topbar_file, $topbarHTML);
			}

			if( $headerHTML != '')
			{
				// Convert html to relative paths
				if($site !== false)
				{
					$headerHTML = SiteUtilities::html_to_relative_path($headerHTML, $site);
				}

				// Write header html to file
                $this->storage->writePage($this->header_file, $headerHTML);
			}

			if( $footerHTML != '')
			{
				// Convert html to relative paths
				if($site !== false)
				{
					$footerHTML = SiteUtilities::html_to_relative_path($footerHTML, $site);
				}

				// Write footer html to file
                $this->storage->writePage($this->footer_file, $footerHTML);
			}
		}

		function saveStyle($folder, $style)
		{
			if(empty($style)){
				return false;
			}

			$cssStr = '';
			foreach($style as $selector => $rule) {
				$cssStr .= $selector ."{\n";
				foreach($rule as $key => $value) {

					if($key == 'filter' && $value == '[object Object]'){
						continue;
					} else if($key == '' || $value == '') {
						continue;
					}

					if($key == 'filter' && stripos($value, 'alpha') !== false ){
						$value = str_replace(array('["','"]'), '', $value);
					}

					$cssStr .= "\t" . $key .": ".$value.";\n";
				}
				$cssStr .= "}\n";
			}

			if( !file_exists($folder.$this->css_file) ) {
				touch($folder.$this->css_file);
			}

			$cs = new CommonStorage();
			$cs->writePage($folder.$this->css_file, $cssStr);

			$linkNode = array(
				'node'=>'link',
				'id'=>$this->style_id,
				'type'=>'text/css',
				'rel'=>'stylesheet',
				'href'=>$this->css_file.'?t='.timeStamp()
			);

			$dynamicHead = new DynamicHead();
			$dynamicHead->save_json_entity($folder, $linkNode);
		}

		function getStyle()
		{
			$cssStr = '<style id="'.$this->style_id.'" type="text/css">'."\n";

			if( $this->storage->fileExists($this->css_file) ) {
				$cssStr .= $this->storage->readPage($this->css_file);
			}

			$cssStr .= '</style>';

			return $cssStr;
		}

		function replaceLinkWithStyle($html)
		{
			return preg_replace('/<link[^>]*id[\s]*=["|\']?'.$this->style_id.'[^>]*>/si', $this->getStyle(), $html);
		}

		function get_header_footer()
		{
			$return = array('head'=>array(), 'topbar'=>'', 'header'=>'', 'footer'=>'');

			// New header & footer Setup
			if( !$this->storage->fileExists($this->header_file) && !$this->storage->fileExists($this->footer_file) ) {
				$return = $this->getDefaultHeaderFooter();
			} else {
				$return['head'][] = $this->getStyle();

				if( $this->storage->fileExists($this->topbar_file) ) {
					$return['topbar'] = $this->storage->readPage($this->topbar_file);
				} else {
					$default = $this->getDefaultHeaderFooter();
					$return['topbar'] = $default['topbar'];
				}

				$return['header'] = $this->storage->readPage($this->header_file);
				$return['footer'] = $this->storage->readPage($this->footer_file);
			}

			return $return;
		}

		function replaceNodeWithPlaceholder($html, $selector, $placeHolder)
		{
			$dom = new simple_html_dom();
			$dom->load($html, true, false);

			$nodes = $dom->find("body > $selector");

			if(count($nodes) > 0) {
				$nodes[0]->outertext = $placeHolder;
				return $dom->save();
			}

			return $html;
		}

		function get_html_with_placeholder($html)
		{
			$htmlClone = $html;

			// First check, if there is topbar

			$html = preg_replace('%(<body[^>]*>[\s]*)<wsc-topbar[^>]*>.*?</wsc-topbar>%sm', '$1'."\n".$this->topbar_place_holder."\n", $html);
			$html = preg_replace('%(<body[^>]*>[\s]*(?:'.$this->topbar_place_holder.')?)[\s]*<header>.*?</header>%sm', '$1'."\n".$this->header_place_holder."\n", $html);
			$html = preg_replace('%<footer>.*?</footer>[\s]*(</body[^>]*>)%sm', "\n".$this->footer_place_holder."\n".'$1', $html);

			return $html;
		}

		function getDefaultHeaderFooter()
		{
			$defaultHeaderFooter = array( 'head' => array(), 'topbar' => '', 'header' => '', 'footer' => '', 'firstTime' => true );

			$path = '/shared/resources/default/header_footer/';

			$cs = new CommonStorage();

			$defaultHeaderFooter['topbar'] = $cs->readPage($path . 'topbar.html');
			$defaultHeaderFooter['header'] = $cs->readPage($path . 'header.html');
			$defaultHeaderFooter['footer'] = $cs->readPage($path . 'footer.html');

			return $defaultHeaderFooter;
		}

		function createTopbarFile($folder)
		{
			if( ! $this->storage->fileExists($folder.$this->topbar_file) ) {
				$default = $this->getDefaultHeaderFooter();
				$topbar = $default['topbar'];

				if(! empty($topbar)) {
                    $this->storage->writePage($folder.$this->topbar_file, $topbar);
				}
			}
		}
	}
