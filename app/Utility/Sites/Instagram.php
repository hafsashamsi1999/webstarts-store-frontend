<?php

namespace App\Utility\Sites;

use App\Models\InstagramAuth;
use GuzzleHttp\Client;

class Instagram {

	protected $client_id = '6966200821414e7c8b9abe070b8fa7a7';
	protected $client_secret = 'c002210091584d848aa50063beffcb4a';
	public $authorized = false;
	public $access_token;
	public $auth_url;
	public $user_id;
	public $webstartsid;
	public $max_id;
	public $results_urls = [];
	public $request_results = [];
	public $vid = [];
	public $img = [];
	public $vid_i = 0;
	public $img_i = 0;
	public $urls_i = 1;
	public $media_set = [];
	public $media_set_i = 1;

    public function __construct()
    {
    	// Chill Pill
    }

    public function get_access_token($userid)
    {
    	$instagramAuth = InstagramAuth::where("webstarts_user_id", $userid)->first();

    	if( ! is_null($instagramAuth)) {
    		return $instagramAuth->access_token;
    	}

    	return false;
    }

    public function get_redirect_url()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        return $protocol . $_SERVER['SERVER_NAME'] . '/' . 'editor/instagram-authorize';
    }

    public function get_auth_url()
	{
		$redirect_url = $this->get_redirect_url();
		return 'https://api.instagram.com/oauth/authorize/?client_id=' . $this->client_id . '&redirect_uri=' . urlencode($redirect_url)  . '&response_type=code';
	}

	public function authenticate_with_id($id)
	{
		return $this->authenticate_with('webstarts_userid', $id);
	}

	public function authenticate_with($type, $value, $force = false)
	{
		$instagramAuth = null;

		switch ($type) {
			case 'webstarts_userid':
				$where = ["webstarts_user_id", $value];
			break;
			case 'instagram_userid':
				$where = ["instagram_userid", $value];
			break;
			case 'instagram_username':
				$where = ["instagram_username", $value];
			break;
		}

		$instagramAuth = InstagramAuth::where([$where])->first();

		if( ! is_null($instagramAuth)) {

		    if($force)
		    {
				$this->user_id = $instagramAuth->instagram_user_id;
				$this->access_token = $instagramAuth->access_token;
				$this->authorized = true;
				return true;
		    }

		    $data = [
		    	'access_token' => $instagramAuth->access_token,
		    	'client_id' => $this->client_id,
		    ];

		    $url = 'https://api.instagram.com/v1/users/' . $instagramAuth->instagram_user_id . '/';
			$response = $this->request($url, 'GET', $data);

		    if( ! $response || ! $response->meta || (isSet($response->meta->error_type) && $response->meta->error_type == 'OAuthAccessTokenException') )
		    {
		    	$auth = InstagramAuth::where("instagram_user_id", $instagramAuth->instagram_user_id)->firstOrFail();
				$auth->delete();
				$this->authorized = false;
		    }
		    else
		    {
		    	$this->user_id = $instagramAuth->instagram_user_id;
		    	$this->access_token = $instagramAuth->access_token;
		    	$this->authorized = true;
		    }
		}

		if( ! $this->authorized)
		{
			$this->userid = false;
			$this->authorized = false;
			$this->auth_url = $this->get_auth_url();
		}

		return $this->authorized;
	}

	public function authorize($code, $userid)
	{
	    $url = "https://api.instagram.com/oauth/access_token";
	    $data = [
	        'client_secret' => $this->client_secret,
	        'client_id' => $this->client_id,
	        'grant_type' => 'authorization_code',
	        'code' => $code,
	        'redirect_uri' => $this->get_redirect_url()
	    ];

	    $response = $this->request($url, 'POST', $data);

	    if(isSet($response->access_token)) {
	    	$access_token = $response->access_token;
	    	$this->authorized = true;
	    	$this->user_id = $response->user->id;

	    	// Destory
			$this->deauthorize($userid);

			// Create
			$auth = InstagramAuth::create([
				'webstarts_user_id' => $userid,
				'access_token' => $response->access_token,
				'instagram_user_id' => $response->user->id,
				'instagram_username' => $response->user->username
			]);

			return true;
		}

		$this->authorized = false;
		return $this->authorized;
	}

	public function deauthorize($userid)
	{
		$auth = InstagramAuth::where("webstarts_user_id", $userid)->firstOrFail();
		$auth->delete();
	}

	public function get_user_id($username, $data = [])
	{
		$data['client_id'] = $this->client_id;
		$data['q'] = $username;
		$url = 'https://api.instagram.com/v1/users/search/';
		$response = $this->request($url, 'GET', $data); //, true ,true

		$data = $response->data;

		if(is_array($data) && count($data) > 0)
		{
			$this->user_id = $data[0]->id;
			return $data[0]->id;
		}

		return false;
	}

	public function count_media($media_set = [], $count = 10)
	{
		$media = $media_set;
		$declare_media_count = $count;
		$count_media_set = [];
		$i = 0;

		// Ensure it's traversable, input isn't cleaned
		if(is_array($media) || $media instanceof Traversable)
		{
			foreach ($media as $m)
			{
				$count_media_set[] = $m;
				if($i > $declare_media_count) break;
				$i++;
			}
		}

		return $count_media_set;
	}

	public function get_user_feed($data = [])
	{
		$user_id = $this->user_id;
		$type = $data['type'];
		unset($data['type']);

		if($this->authorized)
		{
			$data['access_token'] = $this->access_token;
		}

		$data['client_id'] = $this->client_id;

		$url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/';
		$response = $this->request($url, 'GET', $data);

		$vid = [];
		$img = [];

		if(isSet($response->data)) {

			$media = $response->data;

			if($type == 'both')
			{
				return $media;
			}
			else if($type == 'vid')
			{
				$i = 0;
				foreach ($media as $m)
				{
					if($m->type == 'video')
					{
						$vid[$i] = $m;
						$i++;
					}
				}
				return $vid;
			}
			else if($type == 'img')
			{
				$i = 0;
				foreach ($media as $m)
				{
					if($m->type == 'image')
					{
						$img[$i] = $m;
						$i++;
					}
				}
				return $img;
			}
		}

		return [];
	}

	public function get_next_url()
	{
		if($this->max_id) {
			return $this->results_urls[$this->urls_i];
		}

		return false;
	}

	public function checkForNextPage($results)
	{
		if(isSet($results->pagination->next_url))
		{
			$this->results_urls[$this->urls_i] = $results->pagination->next_url;
			return true;
		}

		return false;
	}

	public function createMedia($media, $type)
	{
		if ($type == 'vid')
		{
			foreach ($media as $m)
			{
				if($m->type == 'video')
				{
					$this->vid[$this->vid_i] = $m;
					$this->vid_i++;
				}
			}
			return;
		}
		elseif ($type == 'img')
		{
			foreach ($media as $m)
			{
				if($m->type == 'image')
				{
					$this->img[$this->img_i] = $m;
					$this->img_i++;
				}
			}
			return;
		}
	}

	public function getMediaFilemanager($media) // Creating this function to avoid the slow cURL and have the filemanager handle the data
	{
	    foreach ($media as $m)
	      {
	            $this->media_set[$this->media_set_i] = $m;
	            $this->media_set_i++;
	      }
	      return;
	}

	public function file_manger_get_user_feed($data = [])
	{
	    $user_id = $this->user_id;
	    $type    = $data['type'];
	    $url     = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/'; //Base_Url for instagram w/out the data attributes
	    $key     = true; //Key to check for next_page in the resuslt pagination
	    $i       = 0;

		//Check if Authorized
		if($this->authorized)
		{
			$data['access_token'] = $this->access_token;
		}

		$response = $this->request($url, 'GET', $data);
		$this->request_results[$i] = $response;
		$i++;

		//Going to check for The requested urls
		while($key)
		{
			if($this->checkForNextPage($response))
			{
				$response = $this->request($this->results_urls[$this->urls_i]);
				$this->request_results[$i] = $response;
				$this->urls_i++;
				$i++;
			}
			else
			{
				$key = false;
			}
		}

		//Setting up for the media creation for loop
		$resultsCount = count($this->request_results);
		$i = 0;
		for($x = $resultsCount; $x >= 0; $x--)
		{
			//Creating Media From Results array
			$media = $this->request_results[$i]->data;
			$this->createMedia($media, $type);
			$i++;
		}

		if($type == 'vid')
		{
			return $this->vid;
		}
		elseif($type == 'img')
		{
			return $this->img;
		}
	}

	public function filemanager_get_data($data = [])
	{
	    $user_id = $this->user_id;
	    //$type    = $data['type'];
	    $url     = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/'; //Base_Url for instagram w/out the data attributes
	    $key     = true; //Key to check for next_page in the resuslt pagination
	    $i       = 0;

	    //Check if Authorized
	    if($this->authorized)
	    {
	      $data['access_token'] = $this->access_token;
	    }

		$response = $this->request($url, 'GET', $data);
		$this->request_results[$i] = $response;
		$i++;

		//Going to check for The requested urls
		while($key)
		{
			if($this->checkForNextPage($results))
			{
				$response = $this->request($this->results_urls[$this->urls_i]);
				$this->request_results[$i] = $response;
				$this->urls_i++;
				$i++;
			}
			else
			{
				$key = false;
			}
		}

		//Setting up for the media creation for loop
		$resultsCount = count($this->request_results);
		$i = 0;
		for($x = $resultsCount; $x >= 0; $x--)
		{
			//Creating Media From Results array
			$media = $this->request_results[$i]->data;
			$this->getMediaFilemanager($media);
			$i++;
		}
		return $this->media_set;
	}

	public function get_hashtag($tag, $data = [])
	{
		$type = $data['type'];
		unset($data['type']);
		$data['client_id'] = $this->client_id;
		$url = 'https://api.instagram.com/v1/tags/' . $tag . '/media/recent';
		$response = $this->request($url, 'GET', $data);

		$vid = [];
		$img = [];
		$media = $response->data;

		if($type == 'both')
		{
			return $media;
		}
		elseif ($type == 'vid')
		{
			$i = 0;
			foreach ($media as $m)
			{
				if($m->type == 'video')
				{
					$vid[$i] = $m;
					$i++;
				}
			}
			return $vid;
		}
		elseif ($type == 'img')
		{
			$i = 0;
			foreach ($media as $m)
			{
				if($m->type == 'image')
				{
					$img[$i] = $m;
					$i++;
				}
			}
			return $img;
		}
	}

	protected function request($url, $method = 'GET', $params = [], $headers = false, $returnInfo = false)
	{
		$client = new Client();

		try {
			$payload = [
				'query' => $params,
				'http_errors' => false,
                'verify' => false,
                'allow_redirects' => true,
                'timeout' => 15,
			];

			if($headers) {
				$payload['headers'] = $headers;
			}

			$response = $client->request($method, $url, $payload);

            $code = $response->getStatusCode();

            if($code == '200') {

            	$contents = $response->getBody()->getContents();

            	try {
   	                 if(!empty($contents) || $contents !== false) {

                        if($returnInfo) {
                        	return ["contents" => json_decode($contents), 'info' => $response->getHeaders()];
                        }

                        return json_decode($contents);
                    }
                } catch(Exception $e) {
                    return $this->response_error("No response from API");
                }
            } else {
            	return $this->response_error("Unknown error with code", $code);
            }

		} catch (RequestException $e) {
        	if ($e->hasResponse()) {
                return $this->response_error($e->getResponse());
            }
        }
	}

	protected function response_error($message, $code=false)
	{
		$response = ["success" => false, "error" => true, "message" => $message];

        if($code)
        	$response["code"] = $code;

        return $response;
	}
}
