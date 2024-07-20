<?php

namespace App\Utility;

use App\Exceptions\Domain\InvalidDomainNameException;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Helpers\WebstartsHelper;
use App\Helpers\Validation;

// API Documentation https://domains.opensrs.guide/docs/overview
class OpenSRS
{
    public static $token = 'E4825DF52B13E3E28BEC1AD5DDF6D';

    public function __construct()
    {
    }

    public static function Process($callArray=[])
    {
        $apiUrl = env('WS_URL').'/api/v1/opensrsProcess';
        $params = [
            'token' => self::$token,
            'query' => $callArray
        ];

        $client = new Client();
        $response = $client->request('POST', $apiUrl, ['form_params' => $params]);

        if($response->getStatusCode() == '200') {
            
            $responseBody = $response->getBody()->getContents();
            Log::channel("openSRS")->info( $responseBody );

            if(empty($responseBody)) {
                return ["data" => ['is_success' => 0]];
            }

            return json_decode($responseBody, true);
        }

        return ["data" => ['is_success' => 0]];
    }

    // https://domains.opensrs.guide/docs/get-domain-1
    public static function GetDomainInfo($domain, $type='all_info')
    {
        throw_if( ! Validation::domainName($domain), InvalidDomainNameException::class, sprintf("Invalid domain '%s' supplied. Domain is either empty or not FQDN.", $domain) );

        $domain = WebstartsHelper::__fqdn($domain);
        $callArray = [
            "func" => 	"lookupGetDomain",
            "attributes" => [
                "domain" 	=> $domain,
                "type" 		=> $type
            ]
        ];
        return self::process($callArray);
    }

    // https://domains.opensrs.guide/docs/get_price
    public static function GetPrice($domain=false, $period=1, $reg_type='new')
    {
        throw_if( ! Validation::domainName($domain), InvalidDomainNameException::class, sprintf("Invalid domain '%s' supplied. Domain is either empty or not FQDN.", $domain) );

        $domain = WebstartsHelper::__fqdn($domain);
        $callArray = [
            "func" => 	"lookupGetPrice",
            "data" => [
                "domain" => $domain
            ]
        ];
        if ( ! empty($period)) 		$callArray['data']['period'] = $period;
        if ( ! empty($reg_type)) 	$callArray['data']['reg_type'] = $reg_type;

        return self::process($callArray);
    }
    

    // https://domains.opensrs.guide/docs/lookup-domain-2
    // Determines the availability of a specified domain name.
    public static function lookupDomain($domain='')
    {
        $domain = WebstartsHelper::__fqdn($domain);
        
        //throw_if( ! Validation::domainName($domain), InvalidDomainNameException::class, sprintf("'%s' is not a valid domain. You need to enter a valid domain name.", $domain) );
        
        $callArray = [
            "func" => 	"lookupLookupDomain",
            "data" => [
                "domain" => $domain,
            ],
        ];

        return self::process($callArray);
    }

    public static function lookupNameSuggest($search_string='')
    {
        $callArray = [
            "func" => 	"lookupNameSuggest",
            "data" => [
                "domain" 	=> $search_string,
                "tlds"  => ['.COM', '.NET', '.ORG', '.INFO', '.BIZ', '.US', '.MOBI'],
            ]
        ];
        return self::process($callArray);
    }

    /**
     * Nameserver Commands End
     * ***************************************
     */
    public static function log_error( $response=[] )
    {
        $err_str = __METHOD__ . "\n" . json_encode($response);
        Log::channel("openSRS")->error( $err_str );
        $response['error'] = TRUE;
        return $response;
    }
}
