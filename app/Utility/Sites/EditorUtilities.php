<?php

namespace App\Utility\Sites;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Sites;
use App\Models\Pages;
use App\Models\Blogs;
use App\Models\AnchorTag;
use App\Models\Guestbook;
use App\Models\BackupFile;
use App\Models\EditorFonts;
use App\Models\FormBuilder;
use App\Models\ResizedImage;
use App\Models\MenusSiteInfo;
use App\Models\PageTemplateDetail;
use App\Utility\simple_html_dom;
use App\Utility\Sites\GetClicky;
use App\Utility\Sites\StaticMenu;
use App\Utility\Sites\RobotHelper;
use App\Utility\Sites\Stylesheet;
use App\Utility\Sites\ViralLinkAdDeal;
use App\Utility\Sites\Editor\LagacyMenu;
use App\Utility\Sites\Dynamic\DynamicHead;
use App\Utility\Sites\Dynamic\DynamicPageHead;

class EditorUtilities {

    public function __construct(Sites $site)
    {
    	$this->site = $site;
    }

    public function getPageHash()
    {
		$pageHash = Pages::where([
            ["siteid", $this->site->id],
            ["templateId", '0'],
            ["active", '1'],
            ["external", '0']
        ])->orderBy('title')->select('name', 'title')->get();

        foreach($pageHash as $key => $_page) {

            $title = $_page["title"];

            if(empty($title)) {
                $title = ucfirst(str_replace(['.htm','.html'], '', $_page['name']));
            }

            $pageHash[$key] = [
                "fileName" => $_page["name"],
                "fileTitle" => $title,
                "type" => "2",
                "icon" => "page2.png"
            ];
        }

        return $pageHash;
    }

    public function createPage(Pages $page, $type, $selPage=false)
    {
        $written = $this->createPhysicalPage($page, $type, $selPage);

        if($written) {
            if($type == "copy") {
                $sourcePage = Pages::getByName($this->site->id, $selPage);
                $page->displayOnMenu = $sourcePage->displayOnMenu;
                $page->parentId = $sourcePage->parentId;
                $page->showMenu = $sourcePage->showMenu;
                $page->phoneView = $sourcePage->phoneView;
                $page->target = $sourcePage->target;
            }

            $saved = $page->save();

            if($this->site->dynamic == false) {
                // update old menu
                $lagacyMenu = new LagacyMenu($this->site);
                $lagacyMenu->pageCreated($page->refresh());
            } else {
                // update static menu
                $menu = new staticMenu($this->site);
                $menu->updateStaticMenu();
            }

            if($saved) {
                return [
                    "success" => true,
                    "error" => false,
                    "legacy" => [
                        "id" => $page->id,
                        "icon" => "page2.png",
                        "type" => "2",
                        "fileName" => $page->name,
                        "fileTitle" => $page->title
                    ],
                    "page" => [
                        "title" => $page->title,
                        "parent" => $page->parentId,
                        "hidden" => 0,
                        "external" => 0,
                        "target" => 0,
                        "isHomePage" => $page->isHomePage,
                        "file" => $page->name,
                        "depth" => 1,
                        "order" => $page->pOrder,
                        "id" => $page->id
                    ]
                ];
            }
        }

        return ["success" => false, "error" => true, "message" => "Unable to create page"];
    }

    public function createPhysicalPage(Pages $page, $type, $selPage=false)
    {
        if($type == 'blank')
        {
            $html = EditorUtilities::getBlankHTML($page->title, $this->site->dynamic);

            if($this->site->dynamic == false)
            {
                // Only add Get Clicky directly in HTML if it's non-dynamic
                $getClicky = new GetClicky($this->site);
                if($getClicky->getUserActivationStatus()) {
                    $html = $getClicky->integrateJSInHTML($html);
                }
            } else {
                /** Page CSS and JSON **/
                $basename = basename($page->name, '.html');
                $styles = [
                    'page' => [
                        'file' => $basename . '.css',
                        'css' => ''
                    ],
                    'pageViewportDesktop' => [
                        'file' => $basename . '-layout-desktop.css',
                        'css' => ''
                    ],
                    'pageViewportPhone' => [
                        'file' => $basename . '-layout-phone.css',
                        'css' => ''
                    ]
                ];

                // Read/write StyleSheets
                foreach($styles as $key => $style) {
                    $this->site->storage()->writePage('css/'.$style['file'], $style['css']);
                }
                /** Page CSS and JSON **/
                $pageHeadEntities = EditorUtilities::getBlankPageHead($basename, $this->site, false);
                $pageHeadFile = 'include/pageheads/'. $page->name . '.json';
                $this->site->storage()->writePage($pageHeadFile, json_encode($pageHeadEntities));

            }
        }
        else if($type == 'copy')
        {
            $sourcePage = Pages::getByName($this->site->id, $selPage);
            $html = $this->site->storage()->readPage($selPage);

            // Dom Ready
            $dom = new simple_html_dom();
            $dom->load($html, true, false);

            /** Check for new Forms and reset **/
            $selector = '.wsform input[name="formid"]';
            foreach($dom->find($selector) as $input) {
                $input->setAttribute("value", "0");
            }

            /** Remove Old Forms 12, Old Blogs 14 and Guestbooks 18 **/
            $selector = 'div[objtype="12"], div[objtype="14"], div[objtype="18"]';
            foreach($dom->find($selector) as $oldElement) {
                $oldElement->outertext = '';
            }

            /** Remove Image Resizer Attributes **/
            foreach($dom->find('img') as $image) {

                // Grab the data-rs-original tag - This tag refers to the original image in the uploads folder
                $src = $image->getAttribute("data-rs-original");

                $image->removeAttribute("data-rs-id");
                $image->removeAttribute("data-rs-size");
                $image->removeAttribute("data-rs-original");

                $image->setAttribute("src", $src);
            }
            /** End Of Remove Image Resizer Attributes **/

            /** Replicate Page Anchors **/
            $anchors = $sourcePage->anchors();
            foreach($anchors as $anchor) {
                AnchorTag::create([
                    "title" => $anchor->title,
                    "element_id" => $anchor->element_id,
                    "pageid" => $anchor->pageid
                ]);
            }
            /** Replicate Page Anchors **/

            /** Replicate Page CSS and JSON **/
            if($this->site->dynamic) {

                // New Page StyleSheets
                $basename = basename($page->name, '.html');
                $sourceBasename = basename($selPage, '.html');

                $styles = [
                    'page' => [
                        'file' => $basename . '.css',
                        'source' => $sourceBasename . '.css'
                    ],
                    'pageViewportDesktop' => [
                        'file' => $basename . '-layout-desktop.css',
                        'source' => $sourceBasename . '-layout-desktop.css'
                    ],
                    'pageViewportPhone' => [
                        'file' => $basename . '-layout-phone.css',
                        'source' => $sourceBasename . '-layout-phone.css'
                    ]
                ];

                // Read/write StyleSheets
                foreach($styles as $key => $style) {
                    if( $this->site->storage()->fileExists('css/'.$style['source']) ) {
                        $css = $this->site->storage()->readPage('css/'.$style['source']);
                        $this->site->storage()->writePage('css/'.$style['file'], $css);
                    }
                }

                // Read/write JSON
                $PageHead = new DynamicPageHead($selPage, $this->site->storage());
                $page_json = $PageHead->load_json();

                if(isSet($page_json['page-title'])) {
                    $page_json['page-title']["innerHTML"] = $page->title;
                }

                if(isSet($page_json['pageCSS'])) {
                    $page_json['pageCSS']["id"] = $page_json['pageCSS']["data-file"] = $styles["page"]["file"];
                    $page_json['pageCSS']["href"] = EditorUtilities::getCSSWithPath($styles["page"]["file"], $this->site);
                }

                if(isSet($page_json['pageViewportDesktopCSS'])) {
                    $page_json['pageViewportDesktopCSS']["id"] = $page_json['pageViewportDesktopCSS']["data-file"] = $styles["page"]["file"];
                    $page_json['pageViewportDesktopCSS']["href"] = EditorUtilities::getCSSWithPath($styles["page"]["file"], $this->site);
                }

                if(isSet($page_json['pageViewportPhoneCSS'])) {
                    $page_json['pageViewportPhoneCSS']["id"] = $page_json['pageViewportPhoneCSS']["data-file"] = $styles["page"]["file"];
                    $page_json['pageViewportPhoneCSS']["href"] = EditorUtilities::getCSSWithPath($styles["page"]["file"], $this->site);
                }

                $pageHeadFile = 'include/pageheads/'. $page->name . '.json';
                $this->site->storage()->writePage($pageHeadFile, json_encode($page_json));
            }
            /** Replicate Page CSS and JSON **/

            // Get the HTML back from $dom
            $html = $dom->save();
        }
        else if($type == 'template')
        {
            $html = $this->getHtmlFromTemplate($page, $selPage);
        }

        return $this->site->storage()->writePage($page->name, $html);
    }

    public function getHtmlFromTemplate($page, $templateId)
    {
        $fonts = [];
        $basename = basename($page->name, '.html');
        $pageCSSFile = $basename.".css";
        $pageViewportDesktopCSSFile = $basename."-layout-desktop.css";
        $pageViewportPhoneCSSFile = $basename."-layout-phone.css";

        $pageHead = EditorUtilities::getBlankPageHead($basename, $this->site, true);

        $style = [
            'page' => ['file' => $pageCSSFile, 'css' => ''],
            'pageViewportDesktop' => ['file' => $pageViewportDesktopCSSFile, 'css' => ''],
            'pageViewportPhone' => ['file' => $pageViewportPhoneCSSFile, 'css' => '']
        ];

        $fixedHtml = '';
        $fullHtml = '';

        // Page template
        $nodes = PageTemplateDetail::find($templateId)->nodes();

        foreach($nodes->get() as $node) {

            $nodeHTML = '<html>'.$node->html.'</html>';
            $dom = new simple_html_dom();
            $dom->load($nodeHTML, true, false);

            $container = 'fixed';
            $skipHTML = false;

            if($dom->find('#fake-body-element')) {
                $skipHTML = true;
            }

            foreach($dom->find('*[objtype]') as $el) {

                if($el->hasAttribute('data-container') && $el->getAttribute('data-container') == 'full') {
                    $container = 'full';
                }

                foreach($el->find('[style*=font-family]') as $elFont) {

                    $attr_style = rtrim($elFont->getAttribute('style'), '; ');
                    $arr_rules = explode(';', $attr_style);

                    foreach($arr_rules as $_rule) {

                        $prop = explode(':', $_rule);

                        if( trim($prop[0]) == 'font-family' ) {
                            $font = trim(str_replace(["'", '"'], "", $prop[1]));

                            if( ! in_array($font, $fonts)) {
                                $fonts[] = $font;
                            }
                        }
                    } // foreach

                } // foreach

            }  // foreach

            if($skipHTML === false) {
                if($container == 'full') {
                    $fullHtml .= $node->html . "\n\t";
                } else {
                    $fixedHtml .= $node->html . "\n\t";
                }
            }

            $css = json_decode($node->css, true);

            foreach($css as $name => $contents) {

                $seprator = "\n";
                $tab = $name == 'pageViewportPhone' ? "\t" : "";

                $strCSS = '';
                foreach($contents as $selector => $rules) {

                    $strRules = '';

                    foreach($rules as $prop => $value) {

                        $strRules .= $prop . ': ' . $value . '; ';
                    }

                    if( !empty($strRules)) {

                        $strCSS .= $tab . $selector . '{ ' . $strRules . '}' . $seprator;
                    }
                }

                if( !empty($strCSS)) {

                    $style[$name]['css'] .= $strCSS;
                }
            }
        } // foreach

        $pageHead['gfonts']['href'] = self::getGoogleFontURL($fonts);

        $hasViewportPhone = (empty($style['pageViewportPhone']['css'])) ? false : true;

        if($hasViewportPhone === false)
        {
            unset($style['pageViewportPhone']);
            unset($pageHead['pageViewportPhoneCSS']);
            $pageHead['convertedViewports']['value'] = 'desktop';
        } else {
            $style['pageViewportPhone']['css'] = "@media (max-width: 767px) {\n/* Start Viewport phone */\n" . $style['pageViewportPhone']['css'] . "\n/* End Viewport phone */\n}";
        }

        $html = EditorUtilities::getBlankHTML($page->title, $this->site->dynamic);

        $dom = new simple_html_dom();
        $dom->load($html, true, false);

        foreach($dom->find('body') as $el) {
            $el->setAttribute("data-page-template", "true");
        }

        foreach($dom->find('#body-full > .content-inner') as $el) {
            $el->innertext = $el->innertext . $fullHtml;
        }

        foreach($dom->find('#body-fixed > .content-inner') as $el) {
            $el->innertext = $el->innertext . $fixedHtml;
        }

        // Saving stylesheet files
        foreach($style as $key => $arr) {
            $file = $arr['file'];
            $contents = $arr['css'];
            $this->site->storage()->writePage('css/'.$file, $contents);
        }

        $pageHeadEntities = [];
        foreach($pageHead as $key => $entity) {
            $pageHeadEntities[] = $entity;
        }

        // Saving json head file
        $pageHeadFile = 'include/pageheads/'. $page->name . '.json';
        $this->site->storage()->writePage($pageHeadFile, json_encode($pageHeadEntities));

        return $dom->save();
    }

    public function backupPage(Pages $page)
    {
        $backupPath = 'backup/';
        $tarFile = $backupPath . $page->name . '_' . date("YmdHis") . '.tar.gz';

        $this->site->storage()->makeDirectory('backup/');
        $result = $this->site->storage()->tar($tarFile, 'cfz', ['css', 'include', $page->name]);

        if ($result) {
            $filesize = $this->site->storage()->getFileSize($tarFile);

            $backup = BackupFile::create([
                "siteid" => $this->site->id,
                "file_path" => $tarFile,
                "file_size" => $filesize,
                "type" => 3
            ])->refresh();

            return $backup;
        } else {
            return false;
        }
    }

    public function deletePage(Pages $page)
    {
        if($page->external == 1) {

            $displayOnMenu = $page->displayOnMenu;
            $page->delete();

            if($displayOnMenu == 1) {
                $menu = new StaticMenu($this->site);
                $menu->updateStaticMenu();
            }

            return true;
        } else {

            // Delete Page Anchors
            $page->anchors()->delete();

            // Delete Resized Images [This is here for cleaning]
            $collect = ResizedImage::where("siteid", $this->site->id)->where("pageid", $page->id);
            $images = $collect->get();
            foreach ($images as $image) {
                $file = 'images/'.$image["resized_name"];
                if($this->site->storage()->fileExists($file)) {
                    $this->site->storage()->delete($file);
                }
            }
            $collect->delete();

            // Delete Robot Page
            $robot = new RobotHelper($this->site);
            $robot->remove($page->id);
            $robot->save_file();

            // Disable Old Form [This is here for cleaning]
            $oldFormUpdate = DB::table('form')
                ->where("siteid", $this->site->id)
                ->where("pageid", $page->id)
                ->update(['status' => 'disabled']);

            if($oldFormUpdate > 0) {
                // Form quota -1
            }

            // Remove Page From Storage
            $this->removePhysicalPage($page);

            // Update sub-pages parent-id
            if($page->displayOnMenu == 1) {
                $pages = Pages::where("siteid", $this->site->id)
                    ->where("parentId", $page->id)
                    ->where("active", "1")
                    ->where("external", "0")
                    ->update(["parentId" => $page->parentId]);
            }

            // Remove Page From DB
            $return = $page->delete();

            if($page->displayOnMenu == 1) {
                $menu = new StaticMenu($this->site);
                $menu->updateStaticMenu();
            } else {
                // Remove page from old menu [This is here for cleaning]
                $lagacyMenu = new LagacyMenu($this->site);
                $lagacyMenu->updateSubPagesParentId($page);
                $lagacyMenu->remove_page_from_menu($page);
            }

            return $return;
        }
    }

    public function removePhysicalPage(Pages $page)
    {
        // Basename without extension
        $basename = basename($page->name, '.html');
        // HTML File
        $page_files = [$page->name];

        if($this->site->dynamic) {
            $page_files[] = "include/pageheads/" . $page->name . ".json"; // Pagehead JSON File
            $page_files[] = "css/" . $basename . '.css'; // Primary css file
            $page_files[] = "css/" . $basename . '-layout-desktop.css'; // Viewport css files
            $page_files[] = "css/" . $basename . '-layout-phone.css';
        }

        // Delete the files
        foreach ($page_files as $file) {
            if($this->site->storage()->fileExists($file)) {
                $this->site->storage()->delete($file);
            }
        }

        // If user deleted his own custom 404.html page, then we need to put back our generic 404.html symlink in his site.
        if ($page->name == '404.html') {
            $this->storage()->symlinkToAbsPath("/web01/resources/404.html", $page->name);
        }
    }

    public function saveExternalStylesheets($Hash)
    {
        // If it isn't set, return
        if(! isset($Hash->externalStylesheetsToSave)) return;

        foreach ($Hash->externalStylesheetsToSave as $file => $css) {
            $Stylesheet = new Stylesheet($this->site->id, $file);
            $Stylesheet->set($css);
        }
    }

    public function saveDynamicHeadContent($Hash)
    {
        if( ! isset($Hash->dynamicHead)) return;
        if( ! isset($Hash->dynamicHead->add) && ! isset($Hash->dynamicHead->remove)) return;

        $pagename = $Hash->pagename;

        if(isset($Hash->dynamicHead->add->site) || isset($Hash->dynamicHead->remove->site))
        {
            $SiteHead = new DynamicHead($this->site->storage());

            if(isset($Hash->dynamicHead->add->site)) {
                $SiteHead->save_json_entities($Hash->dynamicHead->add->site);
            }

            if(isset($Hash->dynamicHead->remove->site)) {
                $SiteHead->remove_json_entities($Hash->dynamicHead->remove->site);
            }
        }

        if(isset($Hash->dynamicHead->add->page) || isset($Hash->dynamicHead->remove->page))
        {
            $PageHead = new DynamicPageHead($pagename, $this->site->storage());

            if(isset($Hash->dynamicHead->add->page)) {
                $PageHead->save_json_entities($Hash->dynamicHead->add->page);
            }

            if(isset($Hash->dynamicHead->remove->page)) {
                $PageHead->remove_json_entities($Hash->dynamicHead->remove->page);
            }
        }
    }

    public function saveStyleMap($Hash)
    {
        // If it isn't set, return
        if( ! isset($Hash->styleMap)) return;
        $style = $Hash->styleMap;

        if(empty($style)) {
            $style = [];
        }

        $folder = 'include';
        $file = $folder . '/stylemap.json';

        $this->site->storage()->makeFolder($folder, 0755);
        $this->site->storage()->writePage($file, json_encode($style));
    }

    public function updatePageAnchors($Hash, Pages $page)
    {
        // If it isn't set, return
        if( ! isset($Hash->anchorTags)) return;

        $accounted_for = [];
        $anchors = $page->anchors()->get();

        foreach($anchors as $anchor) {

            $element_id = $anchor->element_id;

            if(isset($Hash->anchorTags->$element_id)) {
                // FOR UPDATES
                $Anchor = AnchorTag::where("pageid", $Hash->pageid)
                        ->where("element_id", $element_id)
                        ->first();

                if(!is_null($Anchor)) {
                    $accounted_for[] = $element_id;
                    if($Anchor->title !== $Hash->anchorTags->$element_id) {
                        $Anchor->title = $Hash->anchorTags->$element_id;
                        $Anchor->save();
                    }
                }

            } else {
                // FOR DELETES
                AnchorTag::where("pageid", $Hash->pageid)
                        ->where("element_id", $element_id)
                        ->delete();
            }
        }

        // If the anchor wasn't an existing anchor, and it's passed, then add it
        foreach($Hash->anchorTags as $element_id => $title) {

            if( ! in_array($element_id, $accounted_for)) {
                AnchorTag::create([
                    "element_id" => $element_id,
                    "title" => $title,
                    "pageid" => $Hash->pageid
                ]);
            }
        }
    }

    public function checkForUpdatePages($Hash)
    {
        // If it isn't set, return
        if( ! isset($Hash->pages) || ! isset($Hash->deletePages)) return;

        if(isset($Hash->pages)) {
            $inserted_pages = [];

            // If the parent of the inserted page is also an inserted page
            // then we need to wait until they get their ids back to store the proper parent id in the db
            $tmp_parents = [];

            foreach($Hash->pages as $id => $page) {

                $P = new Pages;
                $tmp_pid = false;

                // Check if this page is an inserted external page
                // If so, we need to insert it into the pages table
                if(substr($id, 0, 6) === "insert") {

                    foreach($page as $key => $val) {

                        $dbKey = $key;

                        switch($key) {
                            case 'hidden':
                                $dbKey = 'displayOnMenu';
                                $val = $val == 0 ? 1 : 0;
                                break;

                            case 'order':
                                $dbKey = 'pOrder';
                                break;

                            case 'parent':
                                $dbKey = 'parentId';
                                break;

                            case 'title':
                                $val = preg_replace("/[<>]/", "", $val);
                                $val = empty($val) ? ucfirst(str_replace(".html", "", $P->name)) : $val; // If title is empty, revert to file name
                                break;
                        }

                        if( isset($P->$dbKey) && $P->$dbKey != $val ) {
                            if($dbKey === 'parentId' && substr($val, 0, 6) === "insert") {
                                $tmp_pid = $val;
                                $P->$dbKey = 0;
                            } else {
                                $P->$dbKey = $val;
                            }
                        }
                    }

                    $P->siteid = $Hash->siteid;
                    $P->save();
                    $inserted_pages[$id] = $P->id;

                    if($tmp_pid) {
                        $tmp_parents[$P->id] = $tmp_pid;
                    }
                }
                // Check if it's an existing page for update
                else if($P = Pages::find($id) && $P->siteid == $Hash->siteid) {

                    $updated = false;

                    foreach($page as $key => $val) {
                        $dbKey = $key;

                        switch($key) {
                            case 'hidden':
                                $dbKey = 'displayOnMenu';
                                $val = $val == 0 ? 1 : 0;
                                break;

                            case 'order':
                                $dbKey = 'pOrder';
                                break;

                            case 'parent':
                                $dbKey = 'parentId';
                                break;

                            case 'title':
                                $val = preg_replace("/[<>]/", "", $val);
                                $val = empty($val) ? ucfirst(str_replace(".html", "", $P->name)) : $val; // If title is empty, revert to file name
                                break;
                        }

                        if( isset($P->$dbKey) && $P->$dbKey != $val ) {
                            $P->$dbKey = $val;
                            $updated = true;
                        }
                    }

                    if($updated) {
                        $P->save();
                    }
                }
            }

            if( ! empty($inserted_pages)) {
                /* Handle temp parent fix */
                foreach ($tmp_parents as $page_id => $tmp_parent_id) {

                    if(isset($inserted_pages[$tmp_parent_id])) {
                        $updated_parent_id = $inserted_pages[$tmp_parent_id];

                        if($P = Pages::find($page_id)) {
                            $P->parentId = $updated_parent_id;
                            $P->save();
                        }
                    }
                }

                /* Format response for updating page ids in UI */
                $returnPage = [];

                foreach($inserted_pages as $oldId => $newId) {
                    $returnPage[] = ["oldId" => $oldId, "newId" => $newId];
                }

                return $returnPage;
            }
        }
    }

    public function handleBlogOnSave($Hash)
    {
        if ($Hash->Blog->insert == 1 || $Hash->Blog->update == 1) {

            $blog_id = $Hash->Blog->blog_id;
            $oldBlog = Blogs::where("id", $blog_id)->first();

            if(stristr($Hash->html, '_blogingContainer') === FALSE) {
                $oldBlog->saved = 1;
                $oldBlog->deleted = 1;
            } else {
                $oldBlog->saved = 1;
            }

            $oldBlog->bdr_txt_color = $Hash->Blog->linkColor;
            $oldBlog->save();
        }
    }

    public function handleGuestbookOnSave($Hash)
    {
        if ($Hash->Guestbook->insert == 1 || $Hash->Guestbook->update == 1) {

            $Guestbook_id = $Hash->Guestbook->Guestbook_id;
            $oldGuestbook = Guestbook::where("id", $Guestbook_id)->first();

            if(stristr($Hash->html, '_GuestbookingContainer') === FALSE) {
                $oldGuestbook->saved = 1;
                $oldGuestbook->deleted = 1;
            } else {
                $oldGuestbook->saved = 1;
            }

            $oldGuestbook->bdr_txt_color = $Hash->Guestbook->linkColor;
            $oldGuestbook->save();
        }
    }

    public function handlePlaylistsOnSave($Hash)
    {
        if(isset($Hash->deletedPlaylists)) {

            $ids = [];
            foreach($Hash->deletedPlaylists as $id => $action) {
                $ids[] = $id;
            }

            return app('App\Http\Controllers\EmbedController')->perform("playlist", "playlist/remove", $ids);
        }
    }

    public function handleFormsOnSave(&$Hash, &$scripts)
    {
        $updated_new_forms = $this->handleNewForms($Hash, $scripts);
        $updated_old_forms = $this->handleOldForms($Hash, $scripts);

        if($updated_new_forms || $updated_old_forms)
        {
            // Get Total form used in site

            $oldFormCount = DB::table('form')
                ->where("siteid", $this->site->id)
                ->where("status", 'enabled')
                ->count();

            $newFormCount = FormBuilder::where('siteid', $this->site->id)
                ->where("active", "1")
                ->count();

            $form_count = (int) $oldFormCount + (int) $newFormCount;

            // Handle Quota here $this->site->setFeature("Form", $form_count)

            $scripts[] = "Editor.cFeatures.Form='$form_count';";
            $scripts[] = "Editor.resetFormBits();";
        }
    }

    public function handleNewForms(&$Hash, &$scripts)
    {
        // New Form
        $form_update = false;
        $pageid = (String) $Hash->pageid;

        // Add Form
        if( !empty($Hash->Forms->add) )
        {
            foreach ($Hash->Forms->add as $elementid => $formid)
            {
                $Form = FormBuilder::where("id", $formid)->first();
                if( ! is_null($Form))
                {
                    $Form->activate_on_page($pageid);
                    $form_update = true;
                }
            }
        }

        // Remove
        if( !empty($Hash->Forms->remove) )
        {
            foreach ($Hash->Forms->remove as $elementid => $formid)
            {
                $Form = FormBuilder::where("id", $formid)->first();
                if( ! is_null($Form))
                {
                    $Form->remove_from_page($pageid);
                    $form_update = true;
                }
            }
        }

        // A list of optionally assignable attributes
        $assignable = ['siteid', 'pageid', 'title', 'description', 'fields', 'confirm_page', 'mailing_list', 'wsc_listid', 'emails', 'is_payment',
                        'captcha', 'external'];

        // Update
        if( !empty($Hash->Forms->update) )
        {
            foreach ($Hash->Forms->update as $elementid => $data)
            {
                if( isset($data->formid) && is_numeric($data->formid) && $data->formid > 0 )
                {
                    $Form = FormBuilder::where("id", $data->formid)
                                ->where("siteid", $data->siteid)
                                ->where("pageid", $data->pageid)
                                ->first();

                    if( ! is_null($Form))
                    {
                        if(isset($data->confirmation_pageid))
                        {
                            $Form->confirm_page = $data->confirmation_pageid;
                        }

                        foreach($assignable as $key)
                        {
                            if( ! isset($data->$key)) continue;

                            switch ($key) {
                                case 'fields':
                                    if( ! is_string($data->$key))
                                    {
                                        $data->$key = (array) $data->$key;
                                    }
                                    break;
                            }

                            $Form->$key = $data->$key;
                        }

                        $Form->active = 1;
                        $Form->parent = 0;

                        $Form->save();
                        $form_update = true;
                    } else {

                        // Hmm from might came from template or other page (page copied feature)
                        $Form = new FormBuilder();

                        if(isset($data->confirmation_pageid))
                        {
                            $Form->confirm_page = $data->confirmation_pageid;
                        }

                        foreach($assignable as $key)
                        {
                            if( ! isset($data->$key)) continue;

                            switch ($key) {
                                case 'fields':
                                    if( ! is_string($data->$key))
                                    {
                                        $data->$key = (array) $data->$key;
                                    }
                                    break;
                            }

                            $Form->$key = $data->$key;
                        }

                        $Form->active = 1;
                        $Form->parent = 0;
                        $Form->save();

                        if($data->formid != $Form->id) {

                            $oldId = $data->formid;
                            $newId = $Form->id;

                            $dom = new simple_html_dom();
                            $dom->load($Hash->html, true, false);

                            $htmlUpdated = false;

                            foreach($dom->find('.wsform input[name="formid"]') as $input)
                            {
                                if($input->value == $oldId)
                                {
                                    $input->setAttribute('value', $newId);
                                    $htmlUpdated = true;
                                }
                            }

                            $prefix = preg_replace('%[\d]+$%m', '', $elementid);

                            if($htmlUpdated) {
                                $Hash->html = $dom->save();

                                if($prefix) {
                                    $scripts[] = "Editor.$('#$prefix$oldId').find('input[name=\"formid\"]').val('$newId');";
                                    $scripts[] = "Editor.plugIns.Forms.update['$prefix$oldId'].formid = '$newId';";
                                }
                            }
                        }
                    }
                }
            }
        }

        return $form_update;
    }

    public function handleOldForms(&$Hash, &$scripts)
    {
        /*
            This old form is not in old editor nor in new editor but some of our customer pages have that form
            Its very difficult to understand whats the purpose of this, so implemented as it was
        */

        $form_update = false;
        $formFeat = 0;
        $pageid = (String) $Hash->pageid;

        if($Hash->FormBuilder->deleteForm == 1)
        {
            $oldFormUpdate = DB::table('form')
                ->where("id", $Hash->FormBuilder->formId)
                ->where("siteid", $this->site->id)
                ->where("pageid", $pageid)
                ->update(['status' => 'disabled']);

            $form_update = true;
        }

        if($Hash->FormBuilder->undoable_form == 1)
        {
            if($pageid) {
                $oldFormUpdate = DB::table('form')
                    ->where("siteid", $this->site->id)
                    ->where("pageid", $pageid)
                    ->update(['status' => 'disabled']);
            }

            if(isSet($Hash->FormBuilder->formId)) {
                $oldFormUpdate = DB::table('form')
                    ->where("siteid", $this->site->id)
                    ->where("id", $Hash->FormBuilder->formId)
                    ->update(['status' => 'enabled']);
            }

            $form_update = true;
        }

        return $form_update;
    }

    public function handleSlideshowOnSave($Hash, &$scripts)
    {
        // New Slideshow
        if($Hash->SlideShowJQ->insert == 1)
        {
            // Handle Quota here $this->site->setFeature("SlideShow", $count)
        }
        else if($Hash->SlideShowJQ->del == 1)
        {
            // Handle Quota here $this->site->setFeature("SlideShow", $count)
        }

        // Old Slideshow
        if($Hash->SlideShow->insert == 1)
        {
            // Old slideshow insert code is not relevent in both editor
            // Just handle quota here $this->site->setFeature("SlideShow", $count)
        }
        else if($Hash->SlideShow->del == 1)
        {
            // Handle Quota here $this->site->setFeature("SlideShow", $count)
        }
    }

    public function handleResizeImagesOnSave($Hash)
    {
        //ResizeImages
        if( ! isset($Hash->resizeImages)) return;

        Log::error("Resized Image called, but not implemented since It was using ImageMagik");
    }

    public function saveFacebookScrapeLinks()
    {
        // This function is not in use
    }

    public static function getCSSWithPath($cssFile, Sites $site)
    {
        return "https://static.secure.website/client-site-resources/{$site->id}/css/{$cssFile}?r=".date('YmdHis');
    }

    public static function getBlankHTML($title, $dynamic)
    {
        if($dynamic) {
            return '<!DOCTYPE html>'."\n".
                        '<html>'."\n".
                        '<head>'."\n".
                            '<title>'.$title.'</title>'."\n".
                        '</head>'."\n".
                        '<body>'."\n".
                            '<header_place_holder></header_place_holder>'."\n".
                            '<div id="body-content">'."\n\t".
                                    '<div id="body-full" class="content-full"><div class="content-inner"><shared_full_place_holder></shared_full_place_holder></div></div>'."\n\t".
                                    '<div id="body-fixed" class="content-fixed"><div class="content-inner"><shared_fixed_place_holder></shared_fixed_place_holder></div></div>'."\n\t".
                                    '<div id="body-bg" class="bg-container"><div class="content-fixed bg wse-pg wse-pg-df" objtype="34"><div class="content-inner"><div class="wseSHBL"></div><div class="wseSHBR"></div><div class="wseSHTL"></div><div class="wseSHTR"></div></div></div></div>'."\n".
                            '</div>'."\n".
                            '<footer_place_holder></footer_place_holder>'."\n".
                        '</body>'."\n".
                        '</html>';
        }

        return '<!DOCTYPE html>'."\n".
                        '<html>'."\n".
                        '<head>'."\n".
                            '<title>'.$title.'</title>'."\n".
                            '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n".
                            '<script id="ws_common" type="text/javascript" src="http://static.secure.website/library/users/ws-common.js"></script>'."\n".
                        '</head>'."\n".
                        '<body>'."\n\t".
                            '<center>'."\n\t\t".
                                '<div style="position:relative;width:960px;height:100%" align="left"></div>'."\n\t".
                            '</center>'."\n".
                        '</body>'."\n".
                        '</html>';
    }

    public static function getBlankPageHead($basename, Sites $site, $withPhone=true)
    {
        $pageCSSFile = $basename.".css";
        $pageViewportDesktopCSSFile = $basename."-layout-desktop.css";
        $pageViewportPhoneCSSFile = $basename."-layout-phone.css";

        $pageHead = [
            'title' => [
                "node" => "title",
                "id" => "page-title",
                "innerHTML" => $basename
            ],
            'generator' => [
                "node" => "meta",
                "id" => "page-generator",
                "name" => "Generator",
                "content" => "WebStarts.com - Editor; page-template;"
            ],
            'convertedViewports' => [
                "node" => "dataonly",
                "id" => "convertedViewports",
                "delimiter" => "|",
                "value" => $withPhone ? "desktop|phone" : "desktop"
            ],
            'positionCSS' => [
                "node" => "link",
                "id" => "position.css",
                "type" => "text/css",
                "rel" => "stylesheet",
                "href" => "css/position.css",
                "data-file" => "position.css"
            ],
            'pageCSS' => [
                "node" => "link",
                "id" => $pageCSSFile,
                "type" => "text/css",
                "rel" => "stylesheet",
                "data-file" => $pageCSSFile,
                "href" => EditorUtilities::getCSSWithPath($pageCSSFile, $site)
            ],
            'pageViewportDesktopCSS' => [
                "node" => "link",
                "id" => $pageViewportDesktopCSSFile,
                "type" => "text/css",
                "rel" => "stylesheet",
                "data-file" => $pageViewportDesktopCSSFile,
                "href" => EditorUtilities::getCSSWithPath($pageViewportDesktopCSSFile, $site),
                "data-viewport" => "desktop"
            ]
        ];

        if($withPhone) {
            $pageHead["pageViewportPhoneCSS"] = [
                "node" => "link",
                "id" => $pageViewportPhoneCSSFile,
                "type" => "text/css",
                "rel" => "stylesheet",
                "data-file" => $pageViewportPhoneCSSFile,
                "href" => EditorUtilities::getCSSWithPath($pageViewportPhoneCSSFile, $site),
                "data-viewport" => "phone"
            ];
        }

        $pageHead["gfonts"] = [
            "node" => "link",
            "id" => "page-gfonts",
            "type" => "text/css",
            "rel" => "stylesheet",
            "href" => ''
        ];

        return $pageHead;
    }

    public static function getGoogleFontURL($fonts = [])
    {
        $googleFontPath = 'https://fonts.googleapis.com/css?family=';
        $fontFamilies = [];
        // example => 'Raleway:100,200,300,400,500,600,700,800,900&amp;subset=all%7CMerriweather:300,400,700,900&amp;subset=all';

        foreach($fonts as $font)
        {
            $EditorFont = EditorFonts::where("name", $font)->first();
            if($EditorFont->external == '1'){
                $fontFamilies[] = str_replace(' ', '+', $EditorFont->name) .':'. str_replace('regular', '400', $EditorFont->variants) . '%26amp;subset=all';
            }

        }

        return $googleFontPath . implode('%7C', $fontFamilies);
    }

    public static function validateStyleMap($file, Sites $site)
    {
        $stylemapStr = '{}';

        if(!is_null($site)) {

            $stylemapStr = $site->storage()->readPage($file);
            $stylemap = json_decode($stylemapStr);

            $pagesCache = [];

            $updated = false;

            foreach ($stylemap as $type => $styles)
            {
                foreach($styles as $class => $style)
                {
                    if(isset($style->pages) && (strpos($style->pages, '.html') !== false || strpos($style->pages, 'shared') !== false))
                    {
                        $newPages = '';
                        $pages = $style->pages;
                        $pages = trim($pages, '[]');
                        $pages = str_replace(' ', '', $pages);
                        $pages = explode(',', $pages);

                        $added = true;

                        foreach ($pages as $i => $pagename)
                        {
                            $pagename = trim($pagename, '"');

                            // Ensure there is a pagename
                            if(empty($pagename)) continue;

                            if($pagename === 'shared')
                            {
                                $newPages .= '0'; // This is a special identifier for shared content (header, footer, shared)
                            }
                            elseif(strpos($pagename, '.html') !== false)
                            {
                                $pagesCache[$pagename] = isset($pagesCache[$pagename]) ? $pagesCache[$pagename] : Pages::getIdByName($siteid, $pagename);
                                $newPages .= $pagesCache[$pagename];
                            }
                            elseif(intval($pagename) !== 0 && intval($pagename) !== 1)
                            {
                                $newPages .= $pagename;
                            }

                            if(count($pages) - 1 !== $i && $added)
                            {
                                $newPages .= ',';
                            }
                        }

                        $style->pages = '[' . $newPages . ']';

                        $updated = true;
                    }
                }
            }

            if($updated)
            {
                $stylemapStr = json_encode($stylemap);
                $site->storage()->writePage($file, $stylemapStr);
            }
        }

        return $stylemap;
    }
}
