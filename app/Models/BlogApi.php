<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Oct 2019 20:54:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BlogApi
 *
 * @property int $id
 * @property int $site_id
 * @property int $blog_id
 * @property \Carbon\Carbon $created_at
 *
 * @package App\Models
 */
class BlogApi extends Eloquent
{
	protected $table = 'blog_api';
	public $timestamps = false;
    public static $api_host = 'https://blog.secure.website/api/v1';
    private $api_secret = '123456789';
    private $token = null;

	protected $casts = [
		'site_id' => 'int',
		'blog_id' => 'int'
	];

	protected $fillable = [
		'site_id',
		'blog_id'
	];


    public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class, 'site_id');
    }

	public static function find_or_create($site_id)
	{
		$BlogApi = self::where('site_id', '=', $site_id)->first();

		if(!empty($BlogApi)) {
			$BlogApi->token = $BlogApi->getToken($site_id);
		} else {
			$BlogApi = $BlogApi->setup($site_id);
		}
		
		return $BlogApi;
	}

    public function deleteBlog()
    {
        $this->request('DELETE', 'blogs/' . $this->blog_id, array(
                'ws_key' => $this->api_secret,
                'blog' => $this->blog_id
        ));

        $this->destroy();
    }

    public function setup($siteId, $name = 'Blog Title', $description = 'Blog Description')
    {
        if(is_null($siteId))
        {
            throw new Exception("There was an issue generating your blog, please try again.");
        }

        $response = $this->request('POST', 'blogs', array(
            'ws_key' => $this->api_secret,
            'name' => $name,
            'description' => $description
        ));

        $blogAPI = self::create([
            'blog_id' => $response->id,
            'site_id' => $siteId
        ]);

        return $blogAPI;
    }

    public function getToken()
    {
        if( ! is_null($this->token))
            return $this->token;
        try {
            $response = $this->request('POST', 'authenticate/token', array(
                'ws_key' => $this->api_secret,
                'blog' => $this->blog_id
            ));

            $this->token = isset($response) && isset($response->token) ? $response->token:null;
        } catch(\Exception $e) {
            $this->token = null;
        }


        return $this->token;
    }

    public function getPublishedPosts($params = array())
    {
        if( ! isset($params['page']))
        {
            $params['page'] = 1;
        }

        return $this->request('GET', 'blogs/' . $this->blog_id . '/posts/published', $params);
    }

    public function getPublishedPost($post_id, $params = array())
    {
        return $this->request('GET', 'blogs/' . $this->blog_id . '/posts/published/' . $post_id, $params);
    }

    private function request($http_verb, $endpoint, $request, $authHeaders = array())
    {
        // Convert the request data to json
        $json_request = json_encode($request);

        // Initialize the curl connection
        $curl = curl_init();

        // Set the options for curl
        curl_setopt($curl, CURLOPT_URL, self::$api_host.'/'.$endpoint);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $http_verb);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_request);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        $headers = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_request)
        );

        foreach($authHeaders as $key => $val)
        {
            $headers[] = "$key: $val";
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Execute the curl request and assign the response to a variable
        $response = curl_exec($curl);

        // Close the curl connection
        curl_close($curl);

        try
        {
            $response = json_decode($response);
        }
        catch(Exception $e)
        {
            $response = json_decode(json_encode(array('error' => 'An unexpected error occurred while requesting blog information')));
        }

        return $response;
    }
}
