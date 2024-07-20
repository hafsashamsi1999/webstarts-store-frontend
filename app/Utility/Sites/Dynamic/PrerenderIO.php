<?php
/* Class heavily influenced by https://github.com/jeroennoten/Laravel-Prerender
 */
class PrerenderIO
{
	private $crawlerUserAgents = array(
        // googlebot, yahoo, and bingbot are not in this list because
        // we support _escaped_fragment_ and want to ensure people aren't
        // penalized for cloaking.
        // 'googlebot',
        // 'yahoo',
        // 'bingbot',
        'baiduspider',
        'facebookexternalhit',
        'twitterbot',
        'rogerbot',
        'linkedinbot',
        'embedly',
        'quora link preview',
        'showyoubot',
        'outbrain',
        'pinterest',
        'developers.google.com/+/web/snippet',
        'slackbot',
        'SemrushBot',
        'SemrushBot-SA'
	);

	private $prerenderToken = 'K8kiPoMdFi3y9BJDhdxl';
	private $prerenderUrl = 'https://service.prerender.io';
    private $enabled = true;

	private function getQuery($key, $default = null)
	{
		return isset($_GET[$key]) ? $_GET[$key] : $default;
	}

	private function getServer($key, $default = null)
	{
		return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
	}

	private function isSecure()
	{
		return (isset($_SERVER['HTTPS']) && ! empty($_SERVER['HTTPS'])) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
	}

    public function shouldShowPrerenderedPage()
    {
        if( ! $this->enabled) return false;

        $userAgent = strtolower($this->getServer('HTTP_USER_AGENT'));

        $isRequestingPrerenderedPage = false;
        if (is_null($userAgent) || empty($userAgent)) return false;
        if ($this->getServer('REQUEST_METHOD') !== 'GET') return false;
        if ( ! is_null($this->getServer('X-BUFFERBOT'))) return true;
        
        // prerender if _escaped_fragment_ is in the query string
        if ( ! is_null($this->getQuery('_escaped_fragment_'))) return true;
        
        // prerender if a crawler is detected
        foreach ($this->crawlerUserAgents as $crawlerUserAgent) {
			if (strpos($userAgent, strtolower($crawlerUserAgent)) !== false) {
				return true;
            }
        }

        return $isRequestingPrerenderedPage;
    }

	private function request($url, $addHeaders = array())
	{
		// Initialize the curl connection
		$curl = curl_init();

		// Set the options for curl
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array();
		foreach($addHeaders as $key => $val)
		{
			$headers[] = "$key: $val";
		}

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		// Execute the curl request and assign the response to a variable
		$response = curl_exec($curl);

		// Close the curl connection
		curl_close($curl);

		return $response;
	}

    public function getPrerenderedPageResponse()
    {
        $headers = array(
            'User-Agent' => $this->getServer('HTTP_USER_AGENT'),
        );

        if ($this->prerenderToken) {
            $headers['X-Prerender-Token'] = $this->prerenderToken;
        }

        $protocol = $this->isSecure() ? 'https' : 'http';
    	$host = $this->getServer('HTTP_HOST');
        $uri = $this->getServer('REQUEST_URI');
        $url = $this->prerenderUrl . '/' . urlencode($protocol.'://'.$host.$uri);

        try {
            return $this->request($url, $headers);
        } catch (Exception $exception) {
            return null;
        }
    }
}