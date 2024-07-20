<?php


namespace App\Utility\Sites\Embed;


use App\Models\BlogApi;
use App\Models\Htaccess;
use App\Models\Pages;
use App\Models\Sites;
use App\Utility\Sites\StaticMenu;

class BlogEmbedder
{
    protected $api;
    protected $site;
    protected $pages;
    protected $_config = null;

    public static $demoId = 1;

    function __construct(Sites $site)
    {
        $this->site = $site;
        $this->api = BlogApi::where('site_id','=',$site->id);
        if(!is_null($this->api)) {
            $this->api->token = $this->api->getToken();
        } else {
            $blogAPI = new BlogApi();
            $this->api = $blogAPI->setup($site);
        }
    }

    public function embed()
    {
        if( ! $this->site->isDynamic)
        {
            throw new Exception("This site is using an older version of the editor that does not support embedding a blog");
        }

        $pages = $this->generatePages();
        $this->generateCss();
        $this->generateSiteHead();
        $this->generatePageHeads();
        $this->generateHtaccessRules();

        $dep = $this->getSiteDependencies();

        $menu = new StaticMenu($this->site);
        $menu->updateStaticMenu();

        return array(
            'pages' => $pages,
            'pages_added' => count($pages),
            'config' => $dep[0],
            'message' => 'Blog embed setup successfully.',
        );
    }

    public static function getDemoId()
    {
        return '1';
    }

    public function generateHtaccessRules()
    {
        $config = $this->getConfig();

        $htaccess = $this->site->htaccess()->first();

        foreach($config as $pageConfig)
        {
            if( ! isset($pageConfig['htaccess']) || empty($pageConfig['htaccess'])) continue;

            foreach($pageConfig['htaccess'] as $key => $val)
            {
                if(isSet($htaccess->features->{$key})) {
                    unset($htaccess->features->{$key});
                }

                $htaccess->features->{$key} = $val;
            }

            $htaccess->save();
            $content = $htaccess->getHtaccessContent();
            $this->site->storage()->writePage('.htaccess', $content);
        }
    }

    public function generateSiteHead()
    {

        $head = new DynamicHead($this->site->storage());
        $head->save_json_entities($this->getSiteDependencies());

        return $this;
    }

    public function generatePageHeads()
    {
        $config = $this->getConfig();


        foreach($config as $key => $pageConfig)
        {
            $page_head = new \DynamicPageHead($pageConfig['file'],$this->site->storage());
            $page_head->save_json_entities($this->getPageDependencies($key));
        }

        return $this;
    }

    public function generateCss()
    {
        $config = $this->getConfig();

        foreach($config as $pageConfig)
        {
            foreach($pageConfig['css'] as $file => $css_string)
            {
                $this->site->storage()->writeFile("css/$file", $css_string);
            }
        }

        return $this;
    }

    public function generatePages()
    {
        $pages = array();
        $tmp = array();
        $config = $this->getConfig();
        $nextSortOrder = Pages::getNextSortOrder($this->site->id);

        foreach($config as $key => $pageConfig)
        {
            $parentId = 0;

            if(isset($pageConfig['parent']))
            {
                if(is_int($pageConfig['parent']))
                {
                    $parentId = $pageConfig['parent'];
                }
                else if(isset($tmp[$pageConfig['parent']]))
                {
                    $parentPage = $tmp[$pageConfig['parent']];
                    $parentId = $parentPage->id;
                }
            }

            if($this->site->storage()->fileExists($pageConfig['file']))
            {
                $page = Pages::where([
                    ['siteid','=',$this->site->id],
                    ['name','LIKE',$pageConfig['file']],
                    ['active','=',1]
                ])->first();
                $pages[] = $page;
                continue;
            }

            // Write the html file
            $html = $this->getPageHtmlWith($pageConfig['html']);
            if( ! $this->site->putPageHTML($pageConfig['file'], $html))
            {
                throw new Exception('Could not create page ' . $pageConfig['name']);
            }

            // Create page db record
            $page = Pages::create([
                'siteid' => $this->site->id,
                'title' => $pageConfig['name'],
                'name' => $pageConfig['file'],
                'parentId' => $parentId,
                'url' => "/sites/" . $this->site->get('foldername') . '/' . $pageConfig['file'],
                'templateId' => 0,
                'active' => 1,
                'displayOnMenu' => $pageConfig['show_on_menu'] ? 1 : 0,
                'showMenu' => 1,
                'pOrder' => $nextSortOrder++
            ]);
            $pages[] = $page;
            $tmp[$key] = $page;
        }

        return $pages;
    }

    public function getPageHtmlWith($body = '')
    {
        return '<!DOCTYPE html>'."\n".
            '<html>'."\n".
            '<head>'."\n".
            '</head>'."\n".
            '<body>'."\n".
            '<header_place_holder></header_place_holder>'."\n".
            '<div id="body-content">'."\n\t".
            '<div id="body-full" class="content-full"><div class="content-inner"><shared_full_place_holder></shared_full_place_holder></div></div>'."\n\t".
            '<div id="body-fixed" class="content-fixed"><div class="content-inner"><shared_fixed_place_holder></shared_fixed_place_holder>'.$body.'</div></div>'."\n\t".
            '<div id="body-bg" class="bg-container"><div class="content-fixed bg wse-pg wse-pg-df" objtype="34"><div class="content-inner"><div class="wseSHBL"></div><div class="wseSHBR"></div><div class="wseSHTL"></div><div class="wseSHTR"></div></div></div></div>'."\n".
            '</div>'."\n".
            '<footer_place_holder></footer_place_holder>'."\n".
            '</body>'."\n".
            '</html>';
    }

    public function getConfig()
    {
        if(isset($this->_config)) return $this->_config;

        $this->_config = array(
            'blog' => array(
                'file' => '__blog.html',
                'url' => 'blog',
                'htaccess' => array(
                    'blog-index' => array(
                        'priority' => 2,
                        'status' => true,
                        'entry' => array(
                            'RewriteEngine on',
                            'RewriteRule ^blog$ /render.php?for=__blog.html&dynamicRouting=blog&ws_prop_dynamic_folder_count=1&%{QUERY_STRING}',
                            'RewriteRule ^__blog.html /blog [R=301,L]',
                            'RewriteRule ^blog/$ /blog [R=301,L]'
                        )
                    )
                ),
                'name' => 'Blog',
                'show_on_menu' => true,
                'html' => '<div id="blogPageWidget" objtype="86" data-dynamic-height="1" class="ws-blog-widget" data-widget-type="Blog" data-prop-layout="classic" data-prop-title-color-class="clr-txt-61" data-prop-show-category="sidebar" data-prop-subtitle-color-class="clr-txt-63" data-prop-content-color-class="clr-txt-61" data-prop-button-background-color-class="clr-bkg-61" data-prop-button-text-color-class="clr-txt-75" data-prop-divider-color-class="clr-brd-72" style="position:absolute;"></div>',
                'css' => array(
                    '__blog-layout-desktop.css' => "/* Start Viewport desktop */\n#body-content { height: 410px; }\n#blogPageWidget { top: 50px; left: 0px; width: 980px; height: 310px; z-index: 101; }\n/* End Viewport desktop */\n",
                    '__blog-layout-phone.css' => "@media (max-width: 767px) {\n/* Start Viewport phone */\n#body-content { height: 410px; }\n#blogPageWidget { top: 50px; left: 0px; width: 320px; height: 310px; z-index: 101; }\n/* End Viewport phone */\n}"
                )
            ),
            'post' => array(
                'parent' => 'blog',
                'file' => '__blog_post.html',
                'url' => 'blog/post/{post_id}',
                'htaccess' => array(
                    'blog-post' => array(
                        'priority' => 2,
                        'status' => true,
                        'entry' => array(
                            'RewriteEngine on',
                            'RewriteRule ^blog/post/([a-z0-9_\-]*)$ /render.php?for=__blog_post.html&dynamicRouting=blogPost&ws_prop_dynamic_folder_count=3&ws_prop_post_id=$1&%{QUERY_STRING}',
                            'RewriteRule ^__blog_post.html /blog/post/newest [R=301,L]'
                        )
                    )
                ),
                'name' => 'Blog Post',
                'show_on_menu' => false,
                'html' => '<div id="blogPostPageWidget" objtype="87" data-dynamic-height="1" class="ws-blog-widget" data-widget-type="Post" data-prop-post-id="dynamic:post_id" data-prop-title-color-class="clr-txt-61" data-prop-show-category="sidebar" data-prop-subtitle-color-class="clr-txt-63" data-prop-content-color-class="clr-txt-61" data-prop-button-background-color-class="clr-bkg-61" data-prop-button-text-color-class="clr-txt-75" style="position: absolute;"></div>',
                'css' => array(
                    '__blog_post-layout-desktop.css' => "/* Start Viewport desktop */\n#body-content { height: 410px; }\n#blogPostPageWidget { top: 50px; left: 0px; width: 980px; height: 310px; z-index: 103; }\n/* End Viewport desktop */\n",
                    '__blog_post-layout-phone.css' => "@media (max-width: 767px) {\n/* Start Viewport phone */\n#body-content { height: 410px; }\n#blogPostPageWidget { top: 50px; left: 0px; width: 320px; height: 310px; z-index: 103; }\n/* End Viewport phone */\n}"
                )
            )
        );

        return $this->_config;
    }

    public function getPageDependencies($page)
    {
        $config = $this->getConfig();
        $pageConfig = $config[$page];
        $basename = str_replace('.html', '', $pageConfig['file']);

        return array(
            /***
             *** Page CSS
             ***/
            array(
                "node" => "link",
                "id" =>  "$basename-layout-desktop.css",
                "type" => "text/css",
                "rel" => "stylesheet",
                "href" => "css/$basename-layout-desktop.css",
                "data-file" => "$basename-layout-desktop.css",
                "data-viewport" => "desktop"
            ),
            array(
                "node" => "link",
                "id" =>  "$basename-layout-phone.css",
                "type" => "text/css",
                "rel" => "stylesheet",
                "href" => "css/$basename-layout-phone.css",
                "data-file" => "$basename-layout-phone.css",
                "data-viewport" => "phone"
            ),
            array(
                "node" => "dataonly",
                "id" => "convertedViewports",
                "value" => "desktop|phone",
                "delimiter" => "|"
            ),

            /***
             *** Blog Dependencies
             ***/
            array(
                "src" => "https://static.secure.website/library/users/react-bundle.js",
                "type" => "text/javascript",
                "data-editor-friendly" => "1",
                "id" => "react-bundle.js",
                "node" => "script"
            ),
            array(
                "type" => "text/javascript",
                "src" => "https://static.secure.website/library/users/blog/blog-widgets.js",
                // "src" => "https://rawgit.com/webstarts/react-blog-embed/master/dist/bundle.js",
                // "src" => "http://localhost:3000/dist/bundle.js",
                "data-editor-friendly" => "1",
                "id" => "blog-widgets.js",
                "node" => "script"
            ),
            array(
                "href" => "https://static.secure.website/library/users/blog/blog-widgets.css",
                // "href" => "https://rawgit.com/webstarts/react-blog-embed/master/style.css",
                // "href" => "http://localhost:3000/style.css",
                "rel" => "stylesheet",
                "id" => "blog-widgets.css",
                "node" => "link"
            ),
            array(
                "href" => "https://static.secure.website/library/users/blog/blog-widgets-phone.css",
                // "href" => "https://rawgit.com/webstarts/react-blog-embed/master/phone.css",
                "rel" => "stylesheet",
                "id" => "blog-widgets-phone.css",
                "node" => "link",
                "data-viewport" => "phone"
            ),
            array(
                "href" => "http://static.secure.website/library/users/fonts/public/css/public-icons.min.css",
                "rel" => "stylesheet",
                "id" => "public-icons-css",
                "node" => "link"
            )
        );
    }

    public function getSiteDependencies()
    {
        $config = $this->getConfig();
        $pages = array();

        foreach($config as $k => $v)
        {
            $pages[$k] = $v['url'];
        }

        return array(
            array(
                "id" => "blog",
                "node" => "dataonly",
                "value" => array(
                    "id" => $this->api->blog_id,
                    "pages" => $pages
                )
            ),
        );
    }
}
