<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Oct 2019 14:13:45 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class S3SiteFilesSetup
 *
 * @property int $id
 * @property int $siteid
 *
 * @package App\Models
 */
class S3SiteFilesSetup extends Eloquent
{
	protected $table = 's3_site_files_setup';
	public $timestamps = false;
	public $token;

    public static $api_host = 'https://uploads.secure.website';
    public static $api_username = 'webstarts';
    public static $api_password = 'WS-pass15';
    public static $api_version = 'v2';
    public static $active_in_old_editor = 1;

	protected $casts = [
		'siteid' => 'int'
	];

	protected $fillable = [
		'siteid'
	];

	public function copyS3FilesFromTemplate($site,$template)
    {
        $S3SiteFiles = self::where('siteid','=',$site->id)->first();
        $S3TemplateFiles = S3TemplateFilesSetup::where('templateid','=',$template->id)->first();
        if(!is_null($S3TemplateFiles)) {
            if(is_null($S3SiteFiles)) {
                self::create(['site'=>$site->id]);
            }
            $this->callAsAdmin('POST', 'site/'.$site->id.'/copy/'.$template->id, [
                'folderName' => 'Template', // Puts this template files in the "template" folder
            ]);
        }
    }

    public function callAsAdmin($http_verb = "GET", $endpoint, $request = array())
    {
        return $this->call($http_verb, $endpoint, $request, array(
            'Username' => self::$api_username,
            'Password' => self::$api_password,
        ));
    }

    public function callAsUser($http_verb = "GET", $endpoint, $request = array())
    {
        if( ! isset($this->token) || empty($token))
        {
            if(isset($this->siteid) && ! empty($this->siteid))
            {
                $this->token = $this->getToken($this->siteid);
            }
        }

        return $this->call($http_verb, $endpoint, $request, array(
            'Token' => $this->token,
            'AppId' => $this->siteid
        ));
    }

    private function call($http_verb, $endpoint, $request, $authHeaders = array())
    {
        // Convert the request data to json
        $json_request = json_encode($request);

        // Initialize the curl connection
        $curl = curl_init();

        // Set the options for curl
        curl_setopt($curl, CURLOPT_URL, self::$api_host.'/'.self::$api_version.'/'.$endpoint);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $http_verb);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_request);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

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

        return json_decode($response);
    }

    public function getToken($site)
    {
            if( is_null($site) )
                return 'no-site';

        // Get token from api
        $response = $this->callAsAdmin('GET', 'token/'.$site->id);

        if(isset($response->error)) {
            return 'token-error-' . str_replace(' ', '-', $response->error->message);
        } else if(isset($response->data)) {
            return $response->data;
        } else {
            return 'token-error';
        }

        return 'token-not-found';
    }

}
