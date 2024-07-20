<?php

namespace App\Utility\Sites;

use App\Models\DomainStatus;
use App\Models\Pages;
use App\Models\Sites;
use App\Models\Sitestats;
use App\Utility\Sites\Dynamic\DynamicHead;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

Class GetClicky {

	protected $__website = 'stats.webstarts.com';
	protected $__APIKey = '360bc400d8533f13';
	protected $ClickyFilePath = 'Scripts/stats-tracking.js';
	protected $log_file_path = '/www/logs/clicky-webstats.log';
	protected $email_address = 'humayun.ghani+analyticserror@gmail.com';
	protected $stats = null;

	/** IMPORTANT
			change this variable to live
			return 'testing_2_4_WWB_'.$userid;
			return 'live_2_4_WWB_'.$userid; for LIVE
	*/

    public function __construct(Sites $site)
    {
    	$this->site = $site;
    	$this->stats = $this->site->siteStats()->first();

    	$this->getClickyUserPrefix();
    	$this->sHTML = '<script id="ClickyStatisticCode" src="'.$this->ClickyFilePath.'"></script>';
    }

    public function activate($account_type)
    {
    	if ($this->createClickyUser($this->site->userid, $account_type))
    	{
	    	$webstarts_domain = !empty($this->site->domain) ? $this->site->domain : 'webstarts.com';

	    	if ($this->createClickySite($this->site->id, $webstarts_domain))
	    	{
	    		if ($this->site->is_dynamic())
	    		{
	    			$this->integrateTrackingEntity();
	    			//echo $this->getPrivateAccessLink().'|CREATED';
	    			if ( ! empty($this->site->domain) ) {
	    				DomainStatus::where('domain', $this->site->domain)->update(['tracking' => 1]);
	    			}
	    			return true;
	    		}
	    		else
	    		{
	    			if ( $this->createJSfile($this->site) AND $this->integrateJSInPages($this->site)){
    					//echo $this->getPrivateAccessLink().'|CREATED';
    					if ( ! empty($this->site->domain) ) {
    						DomainStatus::where('domain', $this->site->domain)->update(['tracking' => 1]);
    					}
    					return true;
	    			}
	    		}
	    	}
    	}

    	return false;
    }

    public function createClickyUserId($userid, $i = NULL)
    {
    	$stats = Sitestats::where("ws_userid", $userid)->first();

    	if(!is_null($stats)) {
    		return $stats->clicky_login_id;
    	}

    	return 'live_WWB'.$i.'_'.$userid;
    }

    public function createClickyPass($userid)
    {
		return md5($userid);
	}

	public function deleteClickyUser()
	{
		$response = $this->request('api', [
			"auth" => $this->__APIKey,
			"type" => "user",
			"user_id" => $this->stats->clicky_userid,
			"delete" => "1",
		]);

		if($response["success"]) {

			// loop through and trim each line to remove the new line character at the end
			$e = $response["data"];
			foreach( $e as $key => $value ) $e[$key] = trim( $value );

			// test for OK or NOK response and react accordingly
			if( trim($e[0]) == "OK" ) {
				if(!is_null($this->stats)) {
					$this->stats->delete();
				}
				return '1';
			} else {
			   Log::error("Clicky API error - User Deletion [deleteClickyUser] \n" .
						  "TimeStamp: " . date('Y-m-d H:i:s') . "\n" .
						  "Response: " . json_encode($e) . "\n" .
						  "WebStarts User ID: " . $this->stats->ws_siteid . "\n" .
						  "Domain: " . $this->__server_name . "\n");
			}
		} else {
			Log::error("Clicky API error - " . $response["message"]);
		}
	}

	public function createClickyUser($webstarts_userid, $account_type='free')
	{
		$this->__account_type = $account_type == 'pro' ? 3 : 1;

		// Checking for Multiple website user creation
		if($this->isClickyUserAccountExist($webstarts_userid)) {
			return true;
		}

		$clickyUserId = $this->createClickyUserId($webstarts_userid);

		$response = $this->request('api', [
			"auth" => $this->__APIKey,
			"type" => "user",
			"username" => $clickyUserId,
			"password" => $this->createClickyPass($webstarts_userid),
			"account_type" => $this->__account_type
		]);

		if($response["success"]) {

			$e = $response["data"];
			foreach( $e as $key => $value ) $e[$key] = trim( $value );

			if ( $e[0] == "NOK" && $e[1] == "5" )
			{
				$i = 0;
				while ( $e[1] == "5" )
				{
					$i++;
					if ( $i == 10 )
						break;

					$clickyUserId = $this->createClickyUserId($webstarts_userid, $i);

					$response = $this->request('api', [
						"auth" => $this->__APIKey,
						"type" => "user",
						"username" => $clickyUserId,
						"password" => $this->createClickyPass($webstarts_userid),
						"account_type" => $this->__account_type
					]);

					if($response["success"]) {
						$e = $response["data"];
					}
				}
			}

			try {
				Log::info("--start:$webstarts_userid--\n" . (is_array($e) ? implode($e) : "") . "--end:$webstarts_userid--\n");
			} catch (Exception $ex) {
				// Do nothing since the response log is failed
			}

			if(is_array($e)) {
				// loop through and trim each line to remove the new line character at the end
				foreach( $e as $key => $value ) $e[$key] = trim( $value );

				if( trim($e[0]) == "OK" ) {
				  // $e[1] is the Clicky user_id, which you need to store on your end for future requests
				  //mysqli_query("update users set clicky_user_id = '$e[1]' where id = '[your_user_id]' limit 1");
					$this->stats = Sitestats::create([
						"ws_userid" => $webstarts_userid,
						"clicky_userid" => trim($e[1]),
						"ws_company_id" => 1,
						"clicky_login_id" => $clickyUserId,
						"clicky_password" => $this->createClickyPass($webstarts_userid)
					])->refresh();

					return true;
				}
			} else {
			   Log::error("Clicky API error - User Creation [createClickyUser]\n" .
						  "TimeStamp: " . date('Y-m-d H:i:s') . "\n" .
						  'error code $e[1]: ' . $e[1]?$e[1]:null . "\n" .
						  'error description $e[2]: ' . $e[2]?$e[2]:null . "\n" .
						  "WebStarts User ID: " . $webstarts_userid . "\n" .
						  "Domain: " . isset($this->__server_name) ?$this->__server_name :'webstarts.com' . "\n");

			    // User already has a getclicky account but is not in the WebStarts database as a getclicky user
				/*if (isset($e[1]) AND $e[1] == 5)
					return 5;
				else*/
					return false;
			}
		}
	}

	public function createClickySite($webstarts_siteid, $webstarts_domain = 'webstarts.com')
	{
		$webstarts_domain = strtolower($webstarts_domain);
		if($webstarts_domain == 'webstarts.com'){
			$webstarts_domain = str_replace('www.', '', $_SERVER['SERVER_NAME']);
		}

		$response = $this->request('api', [
			"auth" => $this->__APIKey,
			"type" => "site",
			"user_id" => $this->stats->clicky_userid,
			"domain" => $webstarts_domain,
			"account_type" => $this->__account_type,
			"timezone" => "-8",
			"dst" => "usa"
		]);
		//dd($response);

		if($response["success"]) {

			$e = $response["data"];
			foreach( $e as $key => $value ) $e[$key] = trim( $value );

			// test for OK or NOK response and react accordingly
			if( trim($e[0]) == "OK" )
			{
			  // $e[1] is the Clicky user_id, which you need to store on your end for future requests
			  //mysqli_query("update users set clicky_user_id = '$e[1]' where id = '[your_user_id]' limit 1");
				if (is_null($this->stats) OR empty($this->stats->id) OR $this->stats->id == 0) {

					$this->stats = Sitestats::create([
						"ws_userid" => $this->stats->clicky_userid,
						"ws_siteid" => $webstarts_siteid,
						"clicky_siteid" => trim($e[1]),
						"clicky_sitekey" => trim($e[2]),
						"clicky_db" => trim($e[3])
					])->refresh();
				} else {
					$this->stats->ws_siteid = $webstarts_siteid;
					$this->stats->clicky_siteid = trim($e[1]);
					$this->stats->clicky_sitekey = trim($e[2]);
					$this->stats->clicky_db = trim($e[3]);
					$this->stats->save();
				}

				return true;

			} else {
			   Log::error("Clicky API error - Site Creation [createClickySite]\n" .
						  "TimeStamp: " . date('Y-m-d H:i:s') . "\n" .
						  'error code $e[1]: ' . $e[1] . "\n" .
						  'error description $e[2]: ' . $e[2] . "\n" .
						  "WebStarts User ID: " . $this->stats->ws_userid . "\n" .
						  "WebStarts Site ID: " . $this->stats->ws_siteid . "\n" .
						  "Domain: " . isset($this->__server_name) ?$this->__server_name :'webstarts.com' . "\n");
			}
		} else {
			Log::error("Clicky API error - " . $response["message"]);
		}

		return false;
	}

	public function trackingCode($jsmode=true)
	{
		if(is_null($this->stats)) {
			Log::error("clicky tracking code called, without object initialization");
			return '';
		}

		if($jsmode) {
			return  'document.write(\'<script src="https://'.$this->__website.'/'.$this->stats->clicky_siteid.'.js" type="text/javascript"></script><noscript><p><img alt="WebStarts Stats" src="https://'.$this->__website.'/'.$this->stats->clicky_siteid.'-'.$this->stats->clicky_db.'.gif" /></p></noscript>\');';
		} else {
			return  '<script src="https://'.$this->__website.'/'.$this->stats->clicky_siteid.'.js" type="text/javascript"></script><noscript><p><img alt="WebStarts Stats" src="https://'.$this->__website.'/'.$this->stats->clicky_siteid.'-'.$this->stats->clicky_db.'.gif" /></p></noscript>';
		}
	}

	public function trackingEntity()
	{
		$file = 'https://'.$this->__website.'/'.$this->stats->clicky_siteid.'.js';
		$script = "_ws.getScript('$file', {documentReady: true, cache: false});";

		return [
			'id'        => 'gc-tracking',
			'node'      => 'script',
			'type'      => 'text/javascript',
			'innerHTML' => $script
		];
	}

	public function integrateTrackingEntity()
	{
		// Get the tracking entity
		$trackingEntity = $this->trackingEntity();

		// Ensure that dynamic head is loaded
		$SiteHead = new DynamicHead($this->site->storage());

		// Save the tracking entity
		$SiteHead->save_json_entity($trackingEntity);
	}

	public function createJSfile()
	{
		// creating file in site folder for every site
		$dir = 'Scripts';
		$filename = 'stats-tracking.js';
		$mystring = $this->trackingCode();

		$this->site->storage()->checkOrCreateFolder($dir);
		$this->site->storage()->writePage($filename, $mystring);
		return true;
	}

	public function integrateJSInPages()
	{
		$pages = Pages::where("siteid", $this->site->id)
				->where("active", "<>", "2")
				->where("external", "0")
				->orderBy('id', 'desc')
				->get();

		foreach($pages as $page) {
			$contents = $this->site->storage()->readPage($page->name);
			$contents = $this->integrateJSInHTML($contents, $page);
			$this->site->storage()->writePage($page->name, $contents);
		}
		return true;
	}

    public function integrateJSInHTML($html, Pages $page)
    {
		$contents = $html;
		if($contents != "")
		{
			// New HTML Structure
			if (preg_match('%<div[^>]*(?:id[\s]*=["|\']?body-fixed["|\']?)[^>]*>%is', $contents, $regs))
			{
				$contents = preg_replace('%(</body>[\s]*</html>)%si', "\n".$this->sHTML."\n$1", $contents);
				$contents = str_replace($regs[0], $this->sHTML.$regs[0], stripslashes($contents));
			}
			else if (preg_match('%</div>[\s]*(?:</center>)?[\s]*</body>%is', $contents, $regs))
			{
				$contents = str_replace($regs[0], $this->sHTML.$regs[0], stripslashes($contents));
			}

		} else {
		   Log::error("Found empty html in integrateJSInHTML function. \n" .
					  "TimeStamp: " . date('Y-m-d H:i:s') . "\n" .
					  "UserID: " . $this->stats->ws_userid . "\n" .
					  "SiteID: " . $this->stats->ws_siteid . "\n" .
					  "Page: " . $page->name). "\n";
		}

		return $contents;
	}

	public function updateClickyUserStatus($user_domain, $account_type='pro', $clicky_user_id)
	{
		$this->__account_type = $account_type == 'pro' ? 3 : 1;

		$response = $this->request('api', [
			"auth" => $this->__APIKey,
			"type" => "user",
			"user_id" => $clicky_user_id,
			"account_type" => $this->__account_type
		]);

		if($response["success"]) {

			// loop through and trim each line to remove the new line character at the end
			$e = $response["data"];
			foreach( $e as $key => $value ) $e[$key] = trim( $value );

			if( trim($e[0]) == "OK" ) {
				return '1';
			} else {
			   Log::error("Clicky API error - Site Creation [updateClickyUserStatus] \n" .
						  "TimeStamp: " . date('Y-m-d H:i:s') . "\n" .
						  'error code $e[1]: ' . $e[1] . "\n" .
						  'error description $e[2]: ' . $e[2] . "\n" .
						  "WebStarts User ID: " . $this->stats->ws_userid . "\n" .
						  "Domain: " . $this->__server_name . "\n");
			}
		} else {
			Log::error("Clicky API error - " . $response["message"]);
		}
	}

	public function updateClickySiteDomain($user_domain)
	{
		$user_domain = strtolower($user_domain);

		$response = $this->request('api', [
			"auth" => $this->__APIKey,
			"type" => "site",
			"site_id" => $this->stats->clicky_siteid,
			"domain" => $user_domain,
			"nickname" => $user_domain
		]);

		if($response["success"]) {

			// loop through and trim each line to remove the new line character at the end
			$e = $response["data"];
			foreach( $e as $key => $value ) $e[$key] = trim( $value );

			if( trim($e[0]) == "OK" ) {
				return '1';
			} else {
			   Log::error("Clicky API error - Site Creation [updateClickySiteDomain] \n" .
						  "TimeStamp: " . date('Y-m-d H:i:s') . "\n" .
						  'error code $e[1]: ' . $e[1] . "\n" .
						  'error description $e[2]: ' . $e[2] . "\n" .
						  "WebStarts User ID: " . $this->stats->ws_userid . "\n" .
						  "WebStarts Site ID: " . $this->stats->ws_siteid . "\n" .
						  "Domain: " . $this->__server_name . "\n");
			}
		} else {
			Log::error("Clicky API error - " . $response["message"]);
		}
	}

	public function deleteClickySite($user_domain)
	{
		$user_domain = strtolower($user_domain);

		$response = $this->request('api', [
			"auth" => $this->__APIKey,
			"type" => "site",
			"site_id" => $this->stats->clicky_siteid,
			"delete" => 1
		]);

		if($response["success"]) {

			// loop through and trim each line to remove the new line character at the end
			$e = $response["data"];
			foreach( $e as $key => $value ) $e[$key] = trim( $value );

			if( trim($e[0]) == "OK" ) {
				if(!is_null($this->stats)) {
					$this->stats->delete();
				}
				return '1';
			} else {
			   Log::error("Clicky API error - Site Deletion [deleteClickySite] \n" .
						  "TimeStamp: " . date('Y-m-d H:i:s') . "\n" .
						  'error code $e[1]: ' . $e[1] . "\n" .
						  'error description $e[2]: ' . $e[2] . "\n" .
						  "WebStarts User ID: " . $this->stats->ws_userid . "\n" .
						  "WebStarts Site ID: " . $this->stats->ws_siteid . "\n" .
						  "Domain: " . $this->__server_name . "\n");
			}
		} else {
			Log::error("Clicky API error - " . $response["message"]);
		}
	}

	public function getPrivateAccessLink()
	{
		return "https://".$this->__website."/user/login?username=".$this->createClickyUserId($this->stats->ws_userid)."&password=".md5($this->stats->ws_userid)."&site_id=".$this->stats->clicky_siteid;
	}

	public function getStatsModel()
	{
		return $this->stats;
	}

	public function getUserStatus($webstarts_userid)
	{
		$stats = Sitestats::where("ws_userid", $webstarts_userid)->first();

    	if(!is_null($this->stats)) {
    		return $stats;
    	}

    	return 0;
	}

	public function getUserActivationStatus()
	{
    	if(!is_null($this->stats)) {
    		return $this->stats;
    	}

    	return false;
	}

    protected function getClickyUserPrefix()
    {
		$server_name = $_SERVER['SERVER_NAME'];
		$server_name = str_replace('www.','',$server_name);
		$this->__server_name = str_replace('.','_',$server_name);
		$this->__server_name = $this->__server_name.'_';
		return $this->__server_name;
    }

    public function isClickyUserAccountExist($webstarts_userid)
    {
    	$stats = Sitestats::where("ws_userid", $webstarts_userid)->first();

    	if(!is_null($stats)) {
    		return $this->stats = $stats;
    	}

    	return false;
    }

	protected function request($endpoint, $params)
	{
		$host = "https://" . $this->__website . "/";
		$client = new Client(['base_uri' => $host]);
		$return = ["success" => false, "error" => true];

        try {
            $api_response = $client->request('GET', $endpoint, [
            	'query' => $params,
                /*'form_params' => $params,
                'http_errors' => false,
                'verify' => false,
                'allow_redirects' => true,
                'timeout' => 20,*/
                //'verify' => 'certificates/certificate.pem'
            ]);

            if($api_response->getStatusCode() == '200') {

            	$responseBody = $api_response->getBody()->getContents();

            	$arr = [];

            	if(!empty($responseBody)) {
            		$arr = preg_split("/\r\n|\n|\r/", $responseBody);
            	}

                try {
   	                 if(!empty($responseBody) || $responseBody !== false) {
                        return ["success" => true, "error" => false, "data" => $arr];
                    }
                } catch(Exception $e) {
                    $return["message"] = "No response from API";
                }
            }

        } catch (RequestException $e) {
        	if ($e->hasResponse()) {
                $return["message"] = $e->getResponse();
            }
        }

        return $return;
	}
}
