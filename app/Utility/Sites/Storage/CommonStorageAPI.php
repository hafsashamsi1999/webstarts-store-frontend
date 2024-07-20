<?php


namespace App\Utility\Sites\Storage;

class CommonStorageAPI {
    // Access using local network to increase performance and to reduce bandwidth cost incurs when you call from public network.
    //public static $api_host = 'http://172.31.22.152/api/v1';
    private $api_token = 'jd092jbkdb&2mx9S';

    public function getURL() {
        return env("STORAGE_API_SERVER") . '/api/v1';
    }

    public function get($endpoint, $input = array(), $headers = array())
    {
        return $this->request('GET', $endpoint, $input, $headers);
    }

    public function put($endpoint, $input = array(), $headers = array())
    {
        return $this->request('PUT', $endpoint, $input, $headers);
    }

    public function post($endpoint, $input = array(), $headers = array())
    {
        return $this->request('POST', $endpoint, $input, $headers);
    }

    public function delete($endpoint, $input = array(), $headers = array())
    {
        return $this->request('DELETE', $endpoint, $input, $headers);
    }

    private function request($http_verb, $endpoint, $request, $extraHeaders = array())
    {
        // Convert the request data to json
        $json_request = json_encode($request);

        //error_log("[$http_verb] $endpoint " . json_encode($request) . "\n", 3, "/tmp/storage-api.log");

        // Initialize the curl connection
        $curl = curl_init();

        // Set the options for curl
        curl_setopt($curl, CURLOPT_URL, self::getURL().'/'.$endpoint);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $http_verb);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_request);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Disable SSL verification, since it's not working
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $headers = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_request),
            'Bearer: ' . $this->api_token
        );

        foreach($extraHeaders as $key => $val)
        {
            $headers[] = "$key: $val";
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Execute the curl request and assign the response to a variable
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // Close the curl connection
        curl_close($curl);

        try
        {
            if(empty($response) || $response === false)
            {
                $response = (object) array('error' => 'An unexpected error occurred','code'=>$httpcode);
            }
            else
            {
                if($httpcode != 200) {
                    $response = (object) array('error' => $response,'code'=>$httpcode);
                } else {
                    $response = json_decode($response);
                    $response->code = $httpcode;
                }
            }
        }
        catch(Exception $e)
        {
            $response = (object) array('error' => 'An unexpected error occurred','code'=>$httpcode);
        }

        //error_log("RESPONSE: " . json_encode($response) . "\n\n", 3, "/tmp/storage-api.log");

        return $response;
    }
}
