<?php


namespace App\Utility\Sites\Embed;


use App\Models\Htaccess;
use App\Models\Pages;
use App\Models\Sites;
use App\Models\SiteUser;
use App\Utility\Sites\StaticMenu;
use App\Utility\Sites\Dynamic\DynamicHead;
use App\Utility\Sites\Dynamic\DynamicPageHead;
use Exception;

class StoreEmbedder
{
    protected $site;
    protected $pages;
    protected $storeId = null;
    protected $_config = null;

    function __construct(Sites $site)
    {
        $this->site = $site;

        $siteStorePivot = SiteUser::where([
            ['siteID','=',$this->site->id],
            ['status','=','1']
        ])->first();

        if(!is_null($siteStorePivot)) {
            $this->storeId = $siteStorePivot->cart_user_id;
        } else {
            // create
        }
    }

    public static function getDemoId()
    {
        return '209697';
    }

    public function embed()
    {
        if(is_null($this->storeId))
        {
            throw new Exception("This site does not have a connected cart");
        }

        if( ! $this->site->is_dynamic())
        {
            throw new Exception("This site is using an older version of the editor that does not support embedding a store");
        }

        $pages = $this->generatePages();
        $this->generateCss();
        $this->generateSiteHead();
        $this->generatePageHeads();
        $this->generateHtaccessRules();

        $this->addStoreBarInAllPages();

        $menu = new StaticMenu($this->site);
        $menu->updateStaticMenu();

        $dep = $this->getSiteDependencies();

        return array(
            'pages' => $pages,
            'pages_added' => count($pages),
            'config' => $dep[0],
            'message' => 'Store embed setup successfully.',
        );
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
            $page_head = new DynamicPageHead($pageConfig['file'],$this->site->storage());
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
        $pages = [];
        $tmp = [];
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

            $html = $this->getPageHtmlWith($pageConfig['html']);
            $html_file = $pageConfig['file'];

            if($this->site->storage()->fileExists($html_file))
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
            'store' => array(
                'file' => '__store.html',
                'url' => 'store',
                'htaccess' => array(
                    'store-index' => array(
                        'priority' => 2,
                        'status' => true,
                        'entry' => array(
                            'RewriteEngine on',
                            'RewriteRule ^store$ /render.php?for=__store.html&dynamicRouting=store&ws_prop_dynamic_folder_count=1&%{QUERY_STRING}',
                            'RewriteRule ^__store.html /store [R=301,L]',
                            'RewriteRule ^store/$ /store [R=301,L]'
                        )
                    )
                ),
                'name' => 'Store',
                'show_on_menu' => true,
                'html' => '<div id="storePageWidget" objtype="80" data-dynamic-height="1" class="wsc-widget" data-widget-type="StorePage" data-prop-desktop-rows="2" data-prop-image-ratio="1:1" data-prop-image-scale="fit" data-prop-desktop-cols="4" data-prop-content-color-class="clr-txt-61" data-prop-button-text-color-class="clr-txt-75" data-prop-button-background-color-class="clr-bkg-61" data-prop-show-sorting="true" data-prop-show-search="true" data-prop-show-category="sidebar" style="position:absolute;"></div>',
                'css' => array(
                    '__store-layout-desktop.css' => "/* Start Viewport desktop */#body-content { height: 410px; }\n\n#storePageWidget { top: 50px; left: 0px; width: 980px; height: 310px; z-index: 101; }\n/* End Viewport desktop */\n",
                    '__store-layout-phone.css' => "@media (max-width: 767px) {\n/* Start Viewport phone */\n#body-content { height: 410px; }\n#storePageWidget { top: 50px; left: 0px; width: 320px; height: 310px; z-index: 101; }\n/* End Viewport phone */\n}"
                )
            ),
            'product' => array(
                'parent' => 'store',
                'file' => '__store_product.html',
                'url' => 'store/product/{product_id}',
                'htaccess' => array(
                    'store-product' => array(
                        'priority' => 2,
                        'status' => true,
                        'entry' => array(
                            'RewriteEngine on',
                            'RewriteRule ^store/product/([a-z0-9_\-]*)$ /render.php?for=__store_product.html&dynamicRouting=storeProduct&ws_prop_dynamic_folder_count=3&ws_prop_product_id=$1&%{QUERY_STRING}',
                            'RewriteRule ^__store_product.html /store/product/newest [R=301,L]'
                        )
                    )
                ),
                'name' => 'Product',
                'show_on_menu' => false,
                'html' => '<div id="storeProductPageWidget" objtype="82" data-dynamic-height="1" class="wsc-widget" data-widget-type="ProductPage" data-prop-product-id="dynamic:product_id" data-prop-content-color-class="clr-txt-61" data-prop-button-background-color-class="clr-bkg-61" data-prop-button-text-color-class="clr-txt-75" data-prop-show-sorting="true" data-prop-show-search="true" data-prop-show-category="sidebar" style="position:absolute;"></div>',
                'css' => array(
                    '__store_product-layout-desktop.css' => "/* Start Viewport desktop */\n#body-content { height: 410px; }\n#storeProductPageWidget { top: 50px; left: 0px; width: 980px; height: 310px; z-index: 103; }\n/* End Viewport desktop */\n",
                    '__store_product-layout-phone.css' => "@media (max-width: 767px) {\n/* Start Viewport phone */#body-content { height: 410px; }\n\n#storeProductPageWidget { top: 50px; left: 0px; width: 320px; height: 310px; z-index: 103; }\n/* End Viewport phone */\n}"
                )
            ),
            'cart' => array(
                'parent' => 'store',
                'file' => '__store_cart.html',
                'url' => 'store/cart',
                'htaccess' => array(
                    'store-cart' => array(
                        'priority' => 2,
                        'status' => true,
                        'entry' => array(
                            'RewriteEngine on',
                            'RewriteRule ^store/cart$ /render.php?for=__store_cart.html&dynamicRouting=storeCart&ws_prop_dynamic_folder_count=2&%{QUERY_STRING}',
                            'RewriteRule ^__store_cart.html /store/cart [R=301,L]',
                            'RewriteRule ^store/cart/$ /store/cart [R=301,L]'
                        )
                    )
                ),
                'name' => 'Cart',
                'show_on_menu' => false,
                'html' => '<div id="storeCartPageWidget" objtype="82" data-dynamic-height="1" class="wsc-widget" data-widget-type="CartPage" data-prop-content-color-class="clr-txt-61" data-prop-button-background-color-class="clr-bkg-61" data-prop-button-text-color-class="clr-txt-75" data-prop-show-sorting="true" data-prop-show-search="true" data-prop-show-category="sidebar" style="position:absolute;"></div>',
                'css' => array(
                    '__store_cart-layout-desktop.css' => "/* Start Viewport desktop */\n#body-content { height: 410px; }\n#storeCartPageWidget { top: 50px; left: 0px; width: 980px; height: 310px; z-index: 103; }\n/* End Viewport desktop */\n",
                    '__store_cart-layout-phone.css' => "@media (max-width: 767px) {\n/* Start Viewport phone */#body-content { height: 410px; }\n\n#storeCartPageWidget { top: 50px; left: 0px; width: 320px; height: 310px; z-index: 103; }\n/* End Viewport phone */\n}"
                )
            ),
            'login' => array(
                'parent' => 'store',
                'file' => '__store_login.html',
                'url' => 'store/login',
                'htaccess' => array(
                    'store-login' => array(
                        'priority' => 2,
                        'status' => true,
                        'entry' => array(
                            'RewriteEngine on',
                            'RewriteRule ^store/login$ /render.php?for=__store_login.html&dynamicRouting=storeCart&ws_prop_dynamic_folder_count=2&%{QUERY_STRING}',
                            'RewriteRule ^__store_login.html /store/login [R=301,L]',
                            'RewriteRule ^store/login/$ /store/login [R=301,L]'
                        )
                    )
                ),
                'name' => 'Login',
                'show_on_menu' => false,
                'html' => '<div id="storeLoginPageWidget" objtype="90" data-dynamic-height="1" class="wsc-widget" data-widget-type="LoginPage" data-prop-content-color-class="clr-txt-61" data-prop-button-background-color-class="clr-bkg-61" data-prop-button-text-color-class="clr-txt-75" style="position:absolute;"></div>',
                'css' => array(
                    '__store_login-layout-desktop.css' => "/* Start Viewport desktop */\n#body-content { height: 410px; }\n#storeLoginPageWidget { top: 0px; left: 0px; width: 980px; height: 310px; z-index: 103; }\n/* End Viewport desktop */\n",
                    '__store_login-layout-phone.css' => "@media (max-width: 767px) {\n/* Start Viewport phone */#body-content { height: 410px; }\n\n#storeLoginPageWidget { top: 0px; left: 0px; width: 320px; height: 310px; z-index: 103; }\n/* End Viewport phone */\n}"
                )
            ),
            'account' => array(
                'parent' => 'store',
                'file' => '__store_account.html',
                'url' => 'store/account',
                'htaccess' => array(
                    'store-account' => array(
                        'priority' => 2,
                        'status' => true,
                        'entry' => array(
                            'RewriteEngine on',
                            'RewriteRule ^store/account$ /render.php?for=__store_account.html&dynamicRouting=storeCart&ws_prop_dynamic_folder_count=2&%{QUERY_STRING}',
                            'RewriteRule ^__store_account.html /store/account [R=301,L]',
                            'RewriteRule ^store/account/$ /store/account [R=301,L]'
                        )
                    )
                ),
                'name' => 'Account',
                'show_on_menu' => false,
                'html' => '<div id="storeAccountPageWidget" objtype="91" data-dynamic-height="1" class="wsc-widget" data-widget-type="AccountPage" data-prop-content-color-class="clr-txt-61" data-prop-button-background-color-class="clr-bkg-61" data-prop-button-text-color-class="clr-txt-75" style="position:absolute;"></div>',
                'css' => array(
                    '__store_account-layout-desktop.css' => "/* Start Viewport desktop */\n#body-content { height: 410px; }\n#storeAccountPageWidget { top: 0px; left: 0px; width: 980px; height: 310px; z-index: 103; }\n/* End Viewport desktop */\n",
                    '__store_account-layout-phone.css' => "@media (max-width: 767px) {\n/* Start Viewport phone */#body-content { height: 410px; }\n\n#storeAccountPageWidget { top: 0px; left: 0px; width: 320px; height: 310px; z-index: 103; }\n/* End Viewport phone */\n}"
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

        $return = array(
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
             *** Store Dependencies
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
                // "src" => "https://rawgit.com/webstarts/react-store-embed/master/dist/bundle.js",
                // "src" => "http://localhost:3000/dist/bundle.js",
                "src" => "https://static.secure.website/library/users/store/store-widgets.js",
                "data-editor-friendly" => "1",
                "id" => "store-widgets.js",
                "node" => "script"
            ),
            array(
                // "href" => "https://rawgit.com/webstarts/react-store-embed/master/style.css",
                // "href" => "http://localhost:3000/style.css",
                "href" => "https://static.secure.website/library/users/store/store-widgets.css",
                "rel" => "stylesheet",
                "id" => "store-widgets.css",
                "node" => "link"
            ),
            array(
                // "href" => "https://rawgit.com/webstarts/react-store-embed/master/phone.css",
                // "href" => "http://localhost:3000/phone.css",
                "href" => "https://static.secure.website/library/users/store/store-widgets-phone.css",
                "rel" => "stylesheet",
                "id" => "store-widgets-phone.css",
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

        return $return;
    }

    public function getSiteDependencies()
    {
        $config = $this->getConfig();
        $pages = array();

        foreach($config as $k => $v)
        {
            $pages[$k] = $v['url'];
        }

        if(is_null($this->storeId))
        {

            $head = new DynamicHead($this->site->storage());
            $json = $head->load_json();
            $store = $head->getEntityById($json, 'store');

            try
            {
                $id = $store['value']['id'];
            }
            catch (Exception $e)
            {
                $id = self::getDemoId();
            }
        }
        else
        {
            $id = $this->storeId;
        }

        return array(
            array(
                "id" => "store",
                "node" => "dataonly",
                "value" => array(
                    "id" => $id,
                    "pages" => $pages
                )
            ),
        );
    }

    public function isStoreEmbeded()
    {
        if(empty($this->storeId)) {
            return false;
        } else {
            $config = $this->getConfig();

            $htaccess = Htaccess::where('siteid','=',$this->site->id)->first();

            // Check if primary store conifig/embed exists
            if( ! isset($config['store'])) return false;

            // Before we were getting false negatives
            // There were cases of stores that didn't have login page embedded, and therefore
            // Were returning false. Despite having a store setup.
            // foreach($config as $pageConfig) {
            $pageConfig = $config['store'];

            if( ! isset($pageConfig['htaccess']) || empty($pageConfig['htaccess'])) return false;

            $return = false;
            foreach($pageConfig['htaccess'] as $key => $val) {

                if(array_key_exists($key, $htaccess->features)) {
                    $return = true;
                } else {
                    return false;
                }
            }
            // }

            return $return;
        }

        return false;
    }

    public function addStoreBarInAllPages() {

        $response = json_decode(exec("php ".base_path()."/artisan addStoreBar $this->site->id"));

    }
}
