<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 17 Oct 2019 21:53:09 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utility\Sites\Storage\CommonStorage;
use App\Utility\Sites\Storage\SiteStorage;
use App\Utility\Sites\Embed\StoreEmbedder;
use App\Utility\Sites\Dynamic\DynamicHead;
use App\Models\Pages;
use Log;
use App\Helpers;

/**
 * Class Site
 *
 * @property int $id
 * @property int $userid
 * @property int $templateid
 * @property string $fileserver
 * @property string $foldername
 * @property string $easyurl
 * @property string $subdomain
 * @property string $domain
 * @property bool $live
 * @property bool $paid
 * @property \Carbon\Carbon $timestamp
 * @property string $editorWidth
 * @property string $editorHeight
 * @property bool $active
 * @property int $physicalStorage
 * @property bool $advanceMode
 * @property string $features
 * @property bool $verified
 * @property bool $beta
 * @property bool $dynamic
 *
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Sites extends Model
{
	public $timestamps = false;
    public $storage = null;

	protected $casts = [
		'userid' => 'int',
		'templateid' => 'int',
		'live' => 'bool',
		'paid' => 'bool',
		'active' => 'bool',
		'physicalStorage' => 'int',
		'advanceMode' => 'bool',
		'verified' => 'bool',
		'beta' => 'bool',
		'dynamic' => 'bool'
	];

	protected $dates = [
		'timestamp'
	];

	protected $fillable = [
		'userid',
		'templateid',
		'fileserver',
		'foldername',
		'easyurl',
		'subdomain',
		'domain',
		'live',
		'paid',
		'timestamp',
		'editorWidth',
		'editorHeight',
		'active',
		'physicalStorage',
		'advanceMode',
		'features',
		'verified',
		'beta',
		'dynamic'
	];

    /* ******************** BEGIN RELATIONSHIPS ******************** */
	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}

	public function subscription()
	{
		return $this->hasOne(\App\Billing\Models\StripeSubscription::class, 'siteid')->where('product_type', 'web-builder')->where('status', '1');
	}

	public function subscriptions()
	{
		return $this->hasMany(\App\Billing\Models\StripeSubscription::class, 'siteid')->where('status', '1');
	}

    public function orders()
    {
        return $this->hasMany(\App\Models\Orders::class, 'site_id');//->where("type", 2);
    }

	public function siteUser()
    {
        return $this->hasOne(\App\Models\SiteUser::class,'siteID');
    }

    public function store()
    {
        return $this->hasOne(\App\Models\SiteUser::class,'siteID')->where('status', '1');
    }

    public function blog()
    {
        return $this->hasOne(\App\Models\BlogApi::class,'site_id');
    }

    public function chatapp()
    {
        return $this->hasOne(\App\Models\ChatApi::class, 'site_id');
    }

    public function embed()
    {
        return $this->hasOne(\App\Models\WsMusicEmbed::class,'site_id');
    }

    public function domains()
    {
        return $this->hasMany(\App\Models\Domaininfo::class, 'site_id');
    }

    public function pages()
    {
        return $this->hasMany(\App\Models\Pages::class, 'siteid');
    }

    public function members()
    {
        return $this->hasMany(\App\Models\UserContact::class, 'site_id')->where("type", 2);
    }

    public function contacts()
    {
        return $this->hasMany(\App\Models\UserContact::class, 'site_id')->where("type", 1);
    }

    public function robot()
    {
        return $this->hasOne(\App\Models\Robot::class, 'siteid');
    }

    public function editorVariables()
    {
        return $this->hasOne(\App\Models\EditorVariables::class,'siteid');
    }

    public function htaccess()
    {
        return $this->hasOne(\App\Models\Htaccess::class,'siteid');
    }

    public function siteStats()
    {
        return $this->hasOne(\App\Models\Sitestats::class,'ws_siteid');
    }

    public function forms()
    {
        return $this->hasOne(\App\Models\FormBuilder::class,'siteid');
    }
    /* ******************** END RELATIONSHIPS ******************** */




    public function storage()
    {
        if (empty($this->storage)) {
            $this->storage = new SiteStorage($this);
        }
        return $this->storage;
    }

    public function createSubdomain(){

        $cs = new CommonStorage();

        if( ! $cs->exists("sites/".$this->foldername."/") )
            return false;

        $dynamicSubdomain = strtolower($this->subdomain);

        if ( ! preg_match('/^[a-zA-Z0-9_-]{3}$/', substr($dynamicSubdomain, 0, 3)))
        {
            // subdomain must start with 3 valid characters
            return false;
        }

        return $cs->createSubdomain($dynamicSubdomain, "sites/".$this->foldername);

    }

    public function getPagesBaseName($home=true)
    {
        $pages = $this->pages()->where('external', 0)->orderBy('active', 'desc')->select('name')->get();

        $pagenames = [];
        foreach ($pages as $page) {
            $pagenames[] = $page->name;
        }
        // Restrict user to create Home (home.html), because this page name creates by default on change design. It should not allowed user to to recreate that page from Add New Page option.
        if ($home)
            $pagenames[] = "home.html";
        
        return $pagenames;
    }

    public function setupRenderForSite()
    {
        $htaccess_content = $this->storage()->readPage('.htaccess');

        if($htaccess_content)
        {
            $htaccess_content = str_replace(' render.php', ' /render.php', $htaccess_content);
            $this->storage()->writePage('.htaccess', $htaccess_content);
        }
    }

    public function getHomePage()
    {
        $default = 'index.html';

        $page = Pages::where([
            ['siteid', $this->id], ['isHomePage', 1], ['external', 0],
        ])->first();

        if(!is_null($page)) {
            return $page->name;
        }

        return $default;
    }

    public function putPageHTML ($pagename, $htmlContent)
    {
        // Replace old custom menu css with new? This is old stuff. Not sure how much it's used (probably some though). Old editor stuff.
        $htmlContent = preg_replace(
            '/<link[^>]*(?:id[\s]*=["|\']?custom_menu_css["|\']?)[^>]*>/si',
            "<link id=\"custom_menu_css\" href=\"css/rollOverEffect.css?t=".time()."\" type=\"text/css\" rel=\"stylesheet\" />",
            stripslashes($htmlContent)
        );

        // strip slashes again? Ok...
        $htmlContent = stripslashes($htmlContent);

        return $this->storage()->writePage($pagename, $htmlContent);
    }

    public function getTitle($pageURL="",$useDomain=true,$forceHttps=false){

        $protocol = $forceHttps ? 'https' : 'http';

        // We don't have SSL Certs on client sites, so we should stick with port 80 requests
        // if ($_SERVER["SERVER_PORT"] == 443){
        // 	$protocol = 'https';
        // }

        if($pageURL == ""){
            if($this->domain && $useDomain){
                $url = $protocol . '://' .$this->domain;
            }elseif($this->subdomain){

                if ($_SERVER["SERVER_PORT"] == 443) { // Now we are going to support https on subdomain
                    $protocol = 'https';
                }

                $url = $protocol . '://' . $this->subdomain . "." . env('domain');
                //$url = $subdomain;
            }elseif($this->easyurl){
                //$url = uriInApp($easyurl);
                $url = $protocol . '://' . $this->fileserver . "/" . $this->easyurl;
            }else{
                $url = uriInApp("sites/".$this->foldername);
            }
        }else{
            $pageName = basename($pageURL);
            if($this->domain){
                $url = $protocol . '://' .$this->domain."/".$pageName;
            }elseif($this->subdomain){

                if ($_SERVER["SERVER_PORT"] == 443) {
                    $protocol = 'https';
                }

                $url = $protocol . '://' . $this->subdomain . "." . env('domain') ."/".$pageName;
            }
            elseif($this->fileserver == NULL || empty($_fileserver) ){
                //$url = uriInApp(rtrim($pageURL,"/"));
                $url = uriInApp("sites/".$this->foldername."/".$pageName);
            }
            else{
                $url = $protocol . '://' . $this->fileserver . "/" . $this->easyurl ."/".$pageName;
            }
        }

        return $url;
    }

    public function getSimpleTitle()
    {
        return !empty($this->domain) ? $this->domain : "{$this->subdomain}.webstarts.com";
    }

    public function uriInApp ($resource)
    {
        $protocol = 'http';
        if ($_SERVER["SERVER_PORT"] == 443)
        {
            $protocol = 'https';
        }
        return $protocol . '://' . $_SERVER["SERVER_NAME"] . '/' . env('baseUrlOfApp') . $resource;
    }

    public function get_cdn_url($path = '')
    {
        $path = ltrim($path, '/');
        return 'https://static.secure.website/client-site-resources/' . $this->id . '/' . $path;
    }

    function mirror_all_page_viewports_from_pagehead_to_db($pages)
    {
        if(!is_null($pages)) {
            foreach($pages as $page) {
                $page->mirror_viewport_from_pagehead($this);
            }
        }
    }

    function hasEmbedded($embed)
    {
        $is_present = false;
        $dh = new DynamicHead($this->storage());
        $dh->load_json();
        foreach($dh->json as $key => $item) {
            if($item['id'] == $embed) {
                $is_present = true;
                break;
            }
        }
        return $is_present;
    }

	public function getPlanLevel()
	{
		if(empty($this->subscription)) {
			return 'Free';
		} else {
			$plan = \App\Billing\Models\StripePlan::find($this->subscription->planid);
			return $plan->name;
		}
	}

    public function getThumbnail($service='url2png')
    {
        switch($service){
            default:
            case 'url2png':
                return $this->getThumbnail_URL2PNG();
            break;

            case 'ws.screenshot':
                $config = ['samedomain' => false, 'fullpage' => 0];
                if($this->external)
                    $config['url'] = $this->getTitle('', true, true);
                    //$config['url'] = "https://{$this->domain}";
                $response = $this->getThumbnail_WEBSTARTS($config);

                if($response['success']) {
                    return $response['url'];
                } else {
                    return $this->getThumbnail(); // use default fallback
                }
            break;
        }
    }

    static public function getConfiguration($key)
    {
        return env($key);
    }

    function getThumbnail_WEBSTARTS($data=[], $endpoint='screenshot') // WebStarts Own Service
    {
        
        return ["success" => false, "message" => "WS Screenshot Service Disabled"];

        $defaults = [
            'token' => self::getConfiguration('WS_SCREENSHOT_TOKEN'),
            'appId' => $this->id,
            'isPhone' => false,
            'viewport' => [1280,960],
            'url' => 'https://' . $this->subdomain .'.'. self::getConfiguration('subdomain_freesites'),
            'format' => 'url',
            'samedomain' => true
        ];

        $data = array_merge($defaults, $data);
        $urlparams = http_build_query($data);
        $screenshotDomain = self::getConfiguration('SCREENSHOT_DOMAIN');
        $url = "$screenshotDomain/api/v2/$endpoint?$urlparams";

        //!checkLive() ?error_log('Screenshot request URL: '. $url) :'';
        //requireOnceInApp('objects/Curl.php');
        $curl = new Curl();
        $responseText = $curl->init($url)->get();
        $response = json_decode($responseText);

        !checkLive() ? error_log('Screenshot response: '. $responseText) : '';
        if(is_object($response) && $response->success) {

            global $basePathOfApp;
            $return = ["success" => true];

            if($data['samedomain']) {
                $uploadFolder = 'site_wizard_tempfiles';
                $dest = $basePathOfApp.'/'.$uploadFolder.'/';

                if($data['format'] == 'base64') { // base64 Deprecated not good for huge image
                    $pngImageData = base64_decode($response->data);
                    $filename = 'screenshot-'.$data['appId'].'-'.time().'.png';
                } else {
                    $source = $response->data;
                    $filename = basename($source);

                    $curl = new Curl();
                    $pngImageData = $curl->init($source)->get();
                    $return['source'] = $source;
                }

                $imageUrl = uriInApp($uploadFolder.'/'.$filename);
                $return['filename'] = $filename;
                $return['url'] = $imageUrl;
                $dest .= $filename;
                if(file_put_contents($dest, $pngImageData)) {
                    return $return;
                }
            } else {
                $return['url'] = $response->data;
                $return['filename'] = basename($response->data);
                return $return;
            }

        } else {
            //error_log($url);
            //error_log('WebStarts Screenshot Service Error: ' . $responseText);
            return ["success" => false, "message" => "WS Screenshot Service Error"];
        }

        return ["success" => false];
    }

    function getThumbnail_URL2PNG()
    {
        $url = 'https://' . $this->subdomain . '.webstarts.com';

        $URL2PNG_APIKEY = "P5425D38579874";
        $URL2PNG_SECRET = "SB9670AAF9937D";

        # urlencode request target
        $options['url'] = urlencode($url);

        $options += array('thumbnail_max_width' => false);
        $options += array('viewport' => '1280x960');

        $homePage = Pages::where([
            ['siteid','=',$this->id],
            ['isHomePage','=','1'],
            ['external','=',0]
        ])->first();

        if(!is_null($homePage)) {
            $options += array('unique' => 'unique-' . urlencode($homePage->updated_at));
        }

        # create the query string based on the options
        foreach($options as $key => $value) { $_parts[] = "$key=$value"; }

        # create a token from the ENTIRE query string
        $query_string = implode("&", $_parts);
        $TOKEN = md5($query_string . $URL2PNG_SECRET);

        return "https://api.url2png.com/v6/$URL2PNG_APIKEY/$TOKEN/png/?$query_string";
    }

    function is_dynamic()
    {
        $is_files_dynamic = $this->is_dynamic_file_check() ? 1 : 0;

        if($this->dynamic != $is_files_dynamic)
        {
            $this->dynamic = $is_files_dynamic;
            $this->save();
        }

        return $is_files_dynamic == 1 ? true : false;
    }

    function is_dynamic_file_check()
    {
        return ($this->storage()->fileExists("include/header.html") && $this->storage()->fileExists("include/footer.html"));
    }

    public function getSiteName($designer)
    {
        if(!is_null($this->domain) && $this->domain != "") {
            return $this->domain;
        } else {
            $url = null;
            if(!is_null($designer)) {
                $url = $designer->domain()->first();
            }
            if(!is_null($url)) {
                if (preg_match("/webstarts\.com/i", $url)) {
                    return "https://".$this->subdomain. '.webstarts.com/';

                } else {
                    return 'http://my.secure.website/' .$this->subdomain. '/';
                }
            } else {
                return  "https://".$this->subdomain. '.webstarts.com/';
            }
        }
    }

    public function getName() {

        // Get the domain first
        if(isset($this->domain) && ! empty($this->domain))
        {
            return str_replace('www.', '', $this->domain);
        }
        // Get the subdomain next
        if(isset($this->subdomain) && ! empty($this->subdomain))
        {
            return $this->subdomain;
        }
        return 'My Site';
    }

    public function removeDomainLink($domain=""){

        if(empty($domain))
            return false;

        $domain = WebstartsHelper::__fqdn($domain);

        $cs = new CommonStorage();
        $result = $cs->removeDomainLink($domain);
        if(!$result) {
            return false;
        }
        return true;
    }

    public function createDynamicDomainSymlink($domain=''){
        if(empty($domain)) {
            $domain = $this->domain;
        }

        if(empty($domain)) {
            return false;
        }

        // Get the domain without www. prefix
        $domain = WebstartsHelper::__fqdn($domain);

        requireOnceInApp("objects/CommonStorage.php");
        $cs = new CommonStorage();
        $result = $cs->createDomain($domain,"sites/".$this->foldername);

        return $result ? true : false;
    }

}