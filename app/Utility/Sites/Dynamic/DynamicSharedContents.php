<?php

	namespace App\Utility\Sites\Dynamic;

	use App\Utility\Sites\SiteUtilities;

	class DynamicSharedContents
	{
		var $includefolder = 'include';
		var $shared_file = 'shared.html';
		var $contents = null;
		var $default_contents = array('full'=>'<shared></shared>','fixed'=>'<shared></shared>');

		var $full_place_holder = '<shared_full_place_holder></shared_full_place_holder>';
		var $fixed_place_holder = '<shared_fixed_place_holder></shared_fixed_place_holder>';

		var $header_place_holder = '<header_place_holder></header_place_holder>';
		var $footer_place_holder = '<footer_place_holder></footer_place_holder>';

		var $full_pattern = '%<shared_full_place_holder>(.*?)</shared_full_place_holder>%si';
		var $fixed_pattern = '%<shared_fixed_place_holder>(.*?)</shared_fixed_place_holder>%si';
		var $body_fixed_pattern = '%<div[^>]*(?:id[\s]*=[\s]*["|\']?body-fixed["|\']?)[^>]*>[\s]*<div[^>]*(?:class[\s]*=["|\']?content-inner)[^>]*>[\s]*(<shared[^>]*>[\s\S]*?</shared>)%si';
		var $body_full_pattern = '%<div[^>]*(?:id[\s]*=[\s]*["|\']?body-full["|\']?)[^>]*>[\s]*<div[^>]*(?:class[\s]*=["|\']?content-inner)[^>]*>[\s]*(<shared[^>]*>[\s\S]*?</shared>)%si';
        public $storage = null;
		function __construct($storage = null)
		{
			$this->shared_file = $this->includefolder. '/' .$this->shared_file;
            $this->storage = $storage;
		}

		function get_full_shared_content($folder, $html, $file, $fromEditor=false,$storage)
		{
            $this->storage = $storage;
			if( $this->storage->fileExists($folder) ) {
				if( empty($this->contents) ){
					$contents = $this->contents = $this->get_contents($folder);
				} else {
					$contents = $this->contents;
				}
			} else {
				$contents = $this->default_contents;
			}

			$html = preg_replace($this->full_pattern, $contents['full'], $html);
			return $html;
		}

		function get_fixed_shared_content($folder, $html, $file, $fromEditor=false,$storage)
		{
            $this->storage = $storage;
			if( $this->storage->fileExists($folder) ) {
				if( empty($this->contents) ){
					$contents = $this->contents = $this->get_contents($folder);
				} else {
					$contents = $this->contents;
				}
			} else {
				$contents = $this->default_contents;
			}

			$html = preg_replace($this->fixed_pattern, $contents['fixed'], $html);
			return $html;
		}

		function get_contents($folder)
		{
			$contents = $this->default_contents;

			if( $this->storage->fileExists($folder) ) {
				$shared_html = $this->storage->readPage($folder.$this->shared_file);

				if (preg_match($this->fixed_pattern, $shared_html, $regs)) {
					$contents['fixed'] = '<shared>'."\n".$regs[1]."\n".'</shared>';
				}
				if (preg_match($this->full_pattern, $shared_html, $regs)) {
					$contents['full'] = '<shared>'."\n".$regs[1]."\n".'</shared>';
				}
			}

			return $contents;
		}

		function save_contents($html, $site = false)
		{
			$contents = array('full'=>'','fixed'=>'');
			$shared_html = '';

			if (preg_match($this->body_fixed_pattern, $html, $regs))
			{
				$contents['fixed'] = preg_replace('%<\/?shared>%si', '', $regs[1]);
				$match = preg_replace('%<shared>(.*?)<\/shared>%si', $this->fixed_place_holder, $regs[0]);
				$html = preg_replace($this->body_fixed_pattern, $match, $html);
			}

			if (preg_match($this->body_full_pattern, $html, $regs))
			{
				$contents['full'] = preg_replace('%<\/?shared>%si', '', $regs[1]);
				$match = preg_replace('%<shared>(.*?)<\/shared>%si', $this->full_place_holder, $regs[0]);
				$html = preg_replace($this->body_full_pattern, $match, $html);
			}

			// Convert html to relative paths
			if($site !== false)
			{
				$contents['full'] = SiteUtilities::html_to_relative_path($contents['full'], $site);
				$contents['fixed'] = SiteUtilities::html_to_relative_path($contents['fixed'], $site);
			}

			$shared_html = '<shared_full_place_holder>'.$contents['full'].'</shared_full_place_holder>'."\n";
			$shared_html .= '<shared_fixed_place_holder>'.$contents['fixed'].'</shared_fixed_place_holder>'."\n";

			//First time setup
			if( ! $this->storage->fileExists('') )
			{
				$this->setupSharedContents($site);
			}

            $this->storage->writePage($this->shared_file, $shared_html);

			return $html;
		}

		function setupSharedContents($site)
		{

			if( $site->backup_html_pages( 'htmlpages_htmlStructure.tar.gz', 'htmlStructure.log' ) ) {

				$params = array(
					'required' => array('objects/Sites.php', 'objects/library/shared_classes/DynamicSharedContents.php'),
					'class' => serialize($this),
					'method' => 'updatePageStructure'
				);

				$site->doWithPagesInBackground( $params );
			}
		}

		function updatePageStructure($pages, $site)
		{
			foreach($pages as $page) {
				$this->updateHTMLStructure($site, $page);
			}
		}

		function updateHTMLStructure($site, $pagename)
		{
			$html = $site->getPageHTML($pagename);

			/*
			 * If we change out the doctype, then it can change the page drastically.
			 * Let the page keep it's doctype, the editor can change it to html5 doctype when the markup is changed
			 *
			// HTML5 Doctype
			$html = preg_replace('%<!DOCTYPE[^>]*?>%', '<!DOCTYPE html>', $html);
			*/

			// <head> tag must be in lowercase for site render
			$html = preg_replace('%<head[^>]*?>%si', '<head>', $html);
			$html = preg_replace('%</head>%si', '</head>', $html);

			if (preg_match('%<div[^>]*(?:id[\s]*=[\s]*["|\']?body-fixed["|\']?)[^>]*>[\s]*<div[^>]*(?:class[\s]*=["|\']?content-inner)[^>]*>[\s]*<shared_fixed_place_holder[^>]*>(.*?)</shared_fixed_place_holder>%si', $html, $regs)) {
				return false;
			} else if (preg_match('%<div[^>]*(?:id[\s]*=[\s]*["|\']?body-fixed["|\']?)[^>]*>[\s]*<div[^>]*(?:class[\s]*=["|\']?content-inner)[^>]*>%si', $html, $regs)) {
				$html = preg_replace('%<div[^>]*(?:id[\s]*=[\s]*["|\']?body-fixed["|\']?)[^>]*>[\s]*<div[^>]*(?:class[\s]*=["|\']?content-inner)[^>]*>%si', "$0\n".$this->fixed_place_holder."\n", $html);
				$html = preg_replace('%<div[^>]*(?:id[\s]*=[\s]*["|\']?body-full["|\']?)[^>]*>[\s]*<div[^>]*(?:class[\s]*=["|\']?content-inner)[^>]*>%si', "$0\n".$this->full_place_holder."\n", $html);
				$site->putPageHTML($pagename, $html);
			} else if (preg_match('%<div[^>]*(?:id[\s]*=[\s]*["|\']?body-fixed["|\']?)[^>]*>%si', $html, $regs)) {
				// need to select new template
			} else {
				if (preg_match('%<body[^>]*>[\s]*(?:<center>)?[\s]*<div[^>]*(?:align[\s]*=["|\']?left["|\']?)[^>]*>(.*?)</div>[\s]*(?:</center>)?[\s]*</body>%si', $html)) {

					$to_width = 980;
					$width = 980;

					if (preg_match('/<body[^>]*>[\s]*(?:<center>)?[\s]*<div[^>]*width[\s]*:([\d]+)(px)?[^>]*>/si', $html, $regs)) {
						$width = intval($regs[1]);
					}

					// Hack to properly center objects from sites with different widths then the width they are converting to
					// Margin will be removed in editor, and substituted for the correct "left" val
					$margin_left = ($to_width - $width) / 2;
					if($margin_left !== 0) {
						$style = '<style type="text/css">'."\n".
									'.converted-page #body-fixed .content-inner > [objtype] { margin-left: '.$margin_left.'px; }'."\n".
								 '</style>';

						$html = preg_replace('%</head>%si', $style."\n$0\n", $html);
					}

					$before =
					// The purpose of .converted-page is to give us the ability to add to the common.css file
					// for old page elements to have one place to quick fix, we remove .converted-page once loaded in the editor
					'<body class="converted-page">'."\n".
						// $this->header_place_holder. // Dynamic header loaded on all pages
						'<div id="body-content">'."\n".
							'<div id="body-full" class="content-full">'.
								'<div class="content-inner">'.$this->full_place_holder.'</div>'.
							'</div>'."\n".
							'<div id="body-fixed" class="content-fixed">'.
								'<div class="content-inner">'.$this->fixed_place_holder;
									/* <!-- This is where all the old HTML will be put --> */
					$after =
								'</div>'.
							'</div>'.
							'<div id="body-bg" class="bg-container">'.
								'<div class="content-fixed bg wse-pg-df" objtype="34">'.
									'<div class="content-inner">'.
										'<div class="wseSHBL"></div><div class="wseSHBR"></div><div class="wseSHTL"></div><div class="wseSHTR"></div>'.
									'</div>'.
								'</div>'.
							'</div>'.
						'</div>'."\n".
						// $this->footer_place_holder. // Dynamic footer loaded on all pages
					'</body>';

					$html = preg_replace('%<body[^>]*>[\s]*<center>[\s]*<div[^>]*>(.*?)</div>[\s]*</center>[\s]*</body>%si', $before."\n$1\n".$after."\n", $html);
					$site->putPageHTML($pagename, $html);
				}
			}
		}

		function file_exists($folder){

			$src = $folder.$this->shared_file;

			clearstatcache(true, $src);
			if( file_exists($src) ) {
				return true;
			} else {
				return false;
			}
		}

		function read_page($file)
		{
			return file_get_contents($file);
		}

		function write_page($file, $html_content)
		{
			return file_put_contents($file, $html_content);
		}
	}
