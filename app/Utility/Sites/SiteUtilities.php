<?php


namespace App\Utility\Sites;


use App\Models\Counter;
use App\Models\EditorVariables;
use App\Models\Htaccess;
use App\Models\Orders;
use App\Models\Pages;
use App\Models\PhotoGallery;
use App\Models\Product;
use App\Models\PurchaseDetails;
use App\Models\S3SiteFilesSetup;
use App\Models\Sale;
use App\Models\User;
use App\Models\Sites;
use App\Models\Template;
use App\Models\ContributorSite;
use App\Utility\Sites\Embed\BlogEmbedder;
use App\Utility\Sites\Embed\StoreEmbedder;
use App\Utility\Sites\Dynamic\DynamicHead;
use App\Utility\Store\Ecommerce;
use App\Utility\Quota\Quota;
use App\Utility\Quota\QuotaLegacy;
use GuzzleHttp\Client;

class SiteUtilities
{

    protected $user;
    protected $site;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function createSiteFromTemplate($template,$subdomain,$phoneView=false) {

        $folders = $this->initializeFolders($subdomain);
        $cs = new CommonStorage();
        $cs->makeDirectory($folders->usersFolder, 0777);
        $cs->makeDirectory($folders->usersSiteFolder, 0777);

        $sitedata =[
            'userid' => $this->user->id,
            'templateid' => $template->id,
            'foldername' => $folders->foldername,
            'subdomain' => $folders->subdomain,
            'dynamic' => 1,
            'timestamp' => date("Y-m-d H:i:s"),
            'editorWidth' => '800',
            'editorHeight'=> '800',
            'fileserver'=>''
        ];

        $src = "shared/themes/template/".$template->id."/* ";
        $src_htaccess = 	"shared/themes/template/".$template->id."/.htaccess";
        $src_template_path = "shared/themes/template/".$template->id."/";
        $dest = "sites/".$folders->foldername."/";
        $cs->copyFolder($src,$dest);
        $cs->copy($src_htaccess,$dest.".htaccess");
        $cs->makeDirectory($dest."uploads", 0777);

        //TODO Create Subdomain folders for access

        $site = Sites::create($sitedata);
        if(!is_null($site)) {


            $this->site = $site;

            $this->site->createSubdomain();

            $this->recordSale();

            $this->createSitePages($template);
            $pg = new PhotoGallery();
            $pg->makeEntriesFromFile($site);

            $evValues = EditorVariables::getDefaults();
            $evValues['siteid'] = $this->site->id;
            $evValues['userid'] = $this->user->id;
            EditorVariables::create($evValues);
            $this->site->setupRenderForSite();

            $s3 = new S3SiteFilesSetup();
            $s3->copyS3FilesFromTemplate($this->site,$template);

            $htaccess = $this->setupHtaccess();
            $forms = $this->setupForms();
            $templateHomePage = Template::getHomePageFromHtaccess($template->id);
            if($templateHomePage) {
                $page = Pages::where([
                        ['siteid','=',$site->id],
                        ['name','LIKE',$templateHomePage],
                        ['external','=',0]
                    ])->first();

                self::setHomePage($page, $site);
            }
            if(!empty($template->extra)) {
                $extra_data = json_decode($template->extra, true);
                $pages = ( !empty($extra_data) AND is_array($extra_data['pages']) ) ? $extra_data['pages'] : false;
                if($pages && is_array($pages)) {
                    Pages::updatePagesData($site,$pages);
                }

            }

            if($site->hasEmbedded('blog')) {
                $embedder = new BlogEmbedder($site);
                $embedder->generateSiteHead();
                $embedder->generateHtaccessRules();
            }

            if($site->hasEmbedded('store')) {
                $embedder = new StoreEmbedder($site);
                $embedder->generateSiteHead();
                $embedder->generateHtaccessRules();
            }

            $pages = (array) Pages::where([
                ['siteid','=',$this->site->id],
                ['external','=','0']
            ])->get();
            $this->site->mirror_all_page_viewports_from_pagehead_to_db($pages);

            $dh = new DynamicHead($this->site->storage());
            if($phoneView === false) {
                $dh->remove_json_entity('renderViewports', TRUE);
            }
            Template::replace_template_resources_with_site($this->site);
            $dh->remove_json_entity('gc-tracking', TRUE);

            return $this->site->id;
        }


        return null;
    }

    protected function initializeFolders($subdomain)
    {
        $object = (object) [];
        $object->subdomain = $subdomain;
        if(empty($subdomain)) {
            $rand3Chars = $this->getRandChar(3);
            $object->subdomain = $rand3Chars.date('YmdHis')."-$this->user->id";
            //              why '7547'?
            //				because it is the word "skip" converted to number format
            //				we can check the db for people who have "skip" and it forces uniqueness
            //				$_GET['title'] = '7547' . microtime(true);
        }
        $object->_siteTitle = "s_".time().rand(1,999);
        $counter = new Counter();
        $mod_value = $counter->getMod();
        $object->usersFolder = 'sites/'.str_pad($mod_value, 4, "0", STR_PAD_LEFT)."/".$this->user->username;
        $object->usersSiteFolder = $object->usersFolder."/".$object->_siteTitle;
        $object->foldername		= str_pad($mod_value, 4, "0", STR_PAD_LEFT)."/".$this->user->username."/".$object->_siteTitle;
        $counter->incrementcount();
        return $object;
    }

    public function recordSale()
    {
        $sale = Sale::where('sale.customerId','=',$this->user->id)
            ->select('sale.id','sale.InvoiceId as inv')
            ->leftJoin('product','sale.productId','=','product.id')
            ->where('sale.site_id','=','0')
            ->where('sale.isComplete','=',1)
            ->orderBy('sale.id','desc')
            ->first();
        if(!is_null($sale)) {
            $sale->site_id = $this->site->id;
            $sale->save();
            $invoice = Orders::where('id','=',$sale->inv)
                ->where('customer_id','=',$this->user->id)
                ->first();
            $invoice->site_id = $this->site->id;
            $invoice->save();
        } else {
            $product = Product::where('id','=',1)->first();
            PurchaseDetails::create([
                'userId'=>$this->user->id,
                'domainnames'=>$product->domainnames,
                'emailaccounts'=>$product->emailaccounts,
                'webpages'=>$product->webpages,
                'websites'=>$product->websites,
                'storagespace'=>$product->storagespace,
                'bandwidth'=>$product->bandwidth,
                'phonesupport'=>$product->phonesupport,
                'features'=>$product->features
            ]);
            Sale::create([
                'customerId'=>$this->user->id,
                'site_id'=>$this->site->id,
                'productId'=>$product->id,
                'isComplete'=>1,
                'timestamp'=>date("Y-m-d H:i:s"),
                'productAmount'=>0.00,
                'setupFee'=>0.00,
                'upsellAmount'=>0.00
            ]);
        }
    }

    public function createSitePages($template)
    {
        $fileArray = $this->site->storage()->getFileListSite('',array("file"),array("html"));
        if($fileArray) {
            for($i=0; $i<count($fileArray); $i++)
            {
                $tmpArr = explode(".", $fileArray[$i]);
                if( $tmpArr[(count($tmpArr)-1)] == "html" )
                {
                    $commonPages = Pages::getCommonPages();

                    $displayOnMenu = 1;
                    if($fileArray[$i] === '404.html') {
                        $displayOnMenu = 0;
                    }

                    // Special pages start with '__', remove that for this calculation
                    $pageName = str_replace('__', '', $fileArray[$i]);
                    $list = explode('_', $pageName);
                    if( isset($list[1]) && $list[1] )
                    {
                        $pageName = str_replace('.html', '', $pageName);
                        $pageName = str_replace('_', ' ', $pageName);
                        $pageName = ucwords($pageName);
                    }
                    else
                    {
                        if(array_key_exists(strtolower($pageName), $commonPages))
                            $pageName = $commonPages[strtolower($pageName)];
                        else
                            $pageName = ucfirst(str_replace('.html', '', $pageName));
                    }
                    Pages::create([
                        "siteid"=>$this->site->id,
                        "title"=>$pageName,
                        "name"=>$fileArray[$i],
                        "url"=>"/sites/".$this->site->foldername."/".$fileArray[$i],
                        "templateId"=>$template->id,
                        "active"=>1,
                        "displayOnMenu"=>$displayOnMenu
                    ]);
                }
            }
        }
    }

    public function setupHtaccess()
    {
        $ht = $this->site->htaccess()->first();
        if(is_null($ht)) {
            $default_features = Htaccess::getDefaultFeatures();
            $ht = Htaccess::create([
                'siteid' => $this->site->id,
                'features' => $default_features,
                'timestamp' => date("Y-m-d H:i:s")
            ]);
            if (!$this->site->storage()->isLink("404.html") && !$this->site->storage()->fileExists("404.html")) {
                $this->site->storage()->symlinkToAbsPath("/web01/resources/404.html","404.html");
            }
        }
        return $ht;
    }

    public function setupForms()
    {
        $pages = $this->site->storage()->getFileListSite("",array("file"),array("html"));

        foreach($pages as $page)
        {

            $html_string = $this->site->storage()->readPage($page);

            $return = Form_Builder::createFromHTML($this->user, $this->site, $page, $html_string);

            if($return->update) {
                $this->storage()->writePage($page, $return->html);
            }
        }
    }

    public function getRandChar($count=3) {
        $arr = array();
        for ( $k=97; $k<123; $k++ ) {
            $arr[] = chr($k);
        }
        $str = '';
        for ($i=0; $i<$count; $i++) {
            if ( $i > 0 ) {
                for ( $j=0; $j<=9; $j++ ) {
                    $arr[] = $j;
                }
            }

            $str .= $arr[rand(0, count($arr)-1)];
        }
        return $str;
    }

    public static function html_to_relative_path($html, Sites $site)
    {
        $html = stripslashes($html);

        $path = [
            'http://' . $_SERVER["SERVER_NAME"] . '/sites/' . $site->foldername .'/',
            'https://' . $_SERVER["SERVER_NAME"] . '/sites/' . $site->foldername .'/',
            $site->getTitle('', false, true).'/',
            $site->getTitle('', false).'/'
        ];

        $regex = [
            '/<(?:img|a|link|script|iframe|embed|param)[^>]*(?:src|href)[\s]*=[\s]*["|\']?([^"\' ]*)["\' ]?[^>]*>/i',
            '/body[\s]*\{[\s]*background[^:]*:[\s]*[^url]*[\s]*url[\s]*\(([^)]*)\)[^}]*\}/i',
            '/background-image[^:]*:[\s]*[^url]*[\s]*url[\s]*\(([^)]*)\)/i',
            '/data-thumb-[a-z0-9\s]*=[\s]*["\']([^"\' ]*)["\']/i',
            '/<div[^>]*data-(?:image-src|src)[\s]*=[\s]*["|\']?([^"\' ]*)["\' ]?[^>]*>/i',
            '/<(?:img|a|div)[^>]*data-srcset[\s]*=[\s]*["|\']?([^"\']*)["\' ]?[^>]*>/i'
        ];

        $make_relative_path = function ($matches) use ($path) {
            $relative_path = str_ireplace($path, "", $matches[1]);
            return str_ireplace($matches[1], $relative_path, $matches[0]);
        };

        $html = preg_replace_callback($regex, $make_relative_path, $html);

        $html = stripslashes($html);

        return $html;
    }

    public static function html_to_absolute_path($html, $site) {

        $userPath = $site->getTitle('', false).'/';

        $cssPath = $userPath . 'css/';
        $uploadsPath = $userPath . 'uploads/';
        $imagesPath = $userPath . 'images/';

        $html = str_ireplace('href="css/','href="'.$cssPath, $html);
        $html = str_ireplace('="images/','="'.$imagesPath, $html);
        $html = str_ireplace('="uploads/','="'.$uploadsPath, $html);
        $html = str_ireplace('file=uploads/','file='.$uploadsPath, $html);
        $html = str_ireplace('url(uploads/','url('.$uploadsPath, $html);

        // Modified above regex to handle anchor links
        preg_match_all('/href[\s]*=[\s]*["|\']?([\w\d-]+\.html[\w\d-#]*)["|\']?/i', $html, $bodyArr);
        for( $i=0; $i<count($bodyArr[0]); $i++ )
        {
            if( !empty($bodyArr[0][$i]) && (strpos($bodyArr[0][$i], "http://") === false) )
                $html = str_ireplace( $bodyArr[0][$i], 'href="'.$userPath.$bodyArr[1][$i].'"', $html);
        }

        return $html;
    }

    public static function setHomePage(Pages $page, Sites $site) {

        $htaccess = $site->htaccess()->first();
        $features = $htaccess->features;

        $features->{'Home-Page'} = [
            'priority' => 2,
            'status' => true,
            'entry' => ['DirectoryIndex '.$page->name]
        ];

        $htaccess->features = $features;
        $htaccess->save();

        $content = $htaccess->getHtaccessContent();
        $site->storage()->writePage('.htaccess', $content);

        // Previously set as homepage in db
        $previousHomePages = Pages::where('siteid', '=', $site->id)
            ->where('isHomePage', '=', 1)
            ->get();

        if(!is_null($previousHomePages)) {
            foreach($previousHomePages as $previousHomePage) {
                $previousHomePage->isHomePage = 0;
                $previousHomePage->save();
            }
        }

        $page->isHomePage = 1;
        $page->updated_at = date("Y-m-d H:i:s");
        $page->save();

        if($site->is_dynamic()) {
            $entity = self::getJSEntityForSiteNavigation($page->name);
            $SiteHead = new DynamicHead($site->storage());
            $SiteHead->save_json_entities($entity);
        }
    }

    public static function getJSEntityForSiteNavigation($homepage='index.html')
    {
        if('__blog.html' == $homepage OR '__store.html' == $homepage){
            $homepage = str_replace(array('__', '.html'), '', $homepage);
        }
        return array(
            array(
                'id' => 'homePage',
                'node' => 'dataonly',
                'value' => $homepage
            )
        );
    }

    public static function get_countries()
    {
        $countryList = [];
        $url = 'http://country.io/names.json';
        $client = new Client();
        $response = $client->request('GET', $url);
        $code = $response->getStatusCode();
        if($code == '200') {
            $contents = $response->getBody()->getContents();
            $countries = json_decode($contents);
            foreach($countries as $code => $country) {
                $countryList[] = $country;
            }
        }
        return $countryList;
    }

    public static function hasEmailMarketing(Sites $site)
    {
        $hasEmailMarketing = false;
        $subscriberLimit = 0;

        //Subscription Billing Check for emailmarketing
        $hasEmailMarketing = Quota::site($site->id)->subscriptions()->hasEmailMarketing();
        if($hasEmailMarketing) {
            $subscriberLimit = $hasEmailMarketing;
            $hasEmailMarketing = true;
        }

        //Legacy Check for emailmarketing
        if(!$hasEmailMarketing) {

            $hasEmailMarketing = QuotaLegacy::site($site->id)->quotas()->hasEmailMarketing();
            if($hasEmailMarketing) {
                //$subscriberLimit = $hasEmailMarketing;
                //$hasEmailMarketing = true;
                $subscriberLimit    = $hasEmailMarketing['marketing_email_subscribers'];
                $hasEmailMarketing  = $hasEmailMarketing['marketing_email_limit'];
            }
        }

        $response = new \stdClass;
        $response->hasEmailMarketing = $hasEmailMarketing;
        $response->subscriberLimit = $subscriberLimit;
        return $response;
    }

    public static function user_have_access_to_site($userid=0, $siteid=0)
    {
        $login_user = user::find($userid);

        if(is_null($login_user)) {
            return false;
        }

        $sites = [];

        // Case 1 - own site
        foreach($login_user->sites()->get() as $site) {
            $sites[] = $site->id;
        }

        if(in_array($siteid, $sites)) {
            return true;
        }

        // Case 2 - designer site
        $designer = $login_user->designer()->first();
        foreach($designer->clients()->get() as $client) {
            $client_user = $client->user()->first();
            foreach($client_user->sites()->get() as $site) {
                 $sites[] = $site->id;
            }
        }

        if(in_array($siteid, $sites)) {
            return true;
        }

        // Case 3 - contributor_sites
        $contributor = ContributorSite::where([
            ["contributorid", $userid],
            ["siteid", $siteid],
            ["roleid", 1],
        ])->first();

        if( ! is_null($contributor)) {
            return true;
        }

        return false;
    }
}
