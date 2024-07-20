<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 20 Oct 2019 03:28:25 +0000.
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SignupInfo
 * 
 * @property int $id
 * @property int $userId
 * @property string $signupIP
 * @property string $loginIP
 * @property string $backTrace
 * @property string $userAgent
 * @property string $countryCode
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $latitude
 * @property string $longitude
 * @property string $timezone
 * @property string $GMTOffset
 * @property string $zipCode
 * @property int $fraud
 * @property \Carbon\Carbon $signupTimestamp
 * @property \Carbon\Carbon $timestamp
 * @property string $referer
 *
 * @package App\Models
 */
class SignupInfo extends Eloquent
{
	protected $table = 'signupInfo';
	public $timestamps = false;

	protected $casts = [
		'userId' => 'int',
		'fraud' => 'int'
	];

	protected $dates = [
		'signupTimestamp',
		'timestamp'
	];

	protected $fillable = [
		'userId',
		'signupIP',
		'loginIP',
		'backTrace',
		'userAgent',
		'countryCode',
		'country',
		'state',
		'city',
		'latitude',
		'longitude',
		'timezone',
		'GMTOffset',
		'zipCode',
		'fraud',
		'signupTimestamp',
		'timestamp',
		'referer'
	];

	public static function getGEOLocationDataByIP($IP)
	{
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://geoip.maxmind.com/geoip/v2.1/city/$IP",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 15,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => [
				"Authorization: Basic ".base64_encode("140321:f6ZPK6Zcj8Hu"), //"Authorization: Basic ".base64_encode("AccountID:LicenseKey"),
				"cache-control: no-cache"
			],
		]);

		$response = curl_exec($curl);
		//error_log("MaxMind resp for IP $IP --- $response\n\n", 3, '/tmp/signupinfo_ip_responses.log');
		$curl_err = curl_error($curl);

		curl_close($curl);

		if ($curl_err) {
			$err = "cURL Error #: $curl_err";
			//error_log("$err\n\n", 3, '/tmp/signupinfo_ip_responses.log');
			throw new \Exception($err, 1);
		} else {
			$geoData = json_decode( $response );
			if (!$geoData) {
				throw new \Exception("Not a valid or empty json response from geoip.maxmind.com", 1);
			}
		}

		$geoData->ipAddress = $IP;
		$geoData = self::maxmind_to_ipinfodb_data($geoData);

		if( $geoData && strtolower($geoData->statusCode) != "ok" ) {
		
			$geoData2 = self::getGEOLocationDataByIP_DB($IP);
			if( $geoData2 && strtolower($geoData2->statusCode) == "ok" ) {
				return $geoData2;
			}
			
			//error_log("GEO API ERROR $IP, Status returned: " . $geoData->statusCode ."\n\n", 3, '/tmp/signupinfo_ip_responses.log');
			$geoData = (object) null;
			$geoData->statusCode = "ERROR";
		}
		
		return $geoData;
	}

	public static function maxmind_to_ipinfodb_data($geoData)
	{
		if( isSet($geoData->registered_country) ) {
			$geoData->country = $geoData->registered_country;
		}
		
		//error_log("maxmind_to_ipinfodb_data: " . json_encode($geoData) ."\n\n", 3, '/tmp/signupinfo_ip_responses.log');
		if (!empty($geoData)) {
			if (isSet($geoData->country->iso_code) AND !empty($geoData->country->iso_code))
				$geoData->statusCode = "OK";
			else
				$geoData->statusCode = "ERROR";

			if (isSet($geoData->country->names->en))
				$geoData->countryName = $geoData->country->names->en;

			if (isSet($geoData->country->iso_code))
				$geoData->countryCode = $geoData->country->iso_code;

			if (isSet($geoData->city->names->en))
				$geoData->cityName = $geoData->city->names->en;

			if (isSet($geoData->subdivisions->names->en) OR isSet($geoData->subdivisions[0]->names->en))
				$geoData->regionName = isSet($geoData->subdivisions->names->en) ? $geoData->subdivisions->names->en : $geoData->subdivisions[0]->names->en;

			if (isSet($geoData->location->time_zone))
				$geoData->timeZone = $geoData->location->time_zone;

			if (isSet($geoData->postal->code))
				$geoData->zipCode = $geoData->postal->code;
			
			if (isSet($geoData->location->latitude))
				$geoData->latitude = $geoData->location->latitude;

			if (isSet($geoData->location->longitude))
				$geoData->longitude = $geoData->location->longitude;
		}
		return $geoData;
	}

	public static function getGEOLocationDataByIP_DB($IP)
	{
		$rows = self::where('signupIP', $IP)
			->whereNotNull('country')
			->select(DB::raw("signupIP AS ipAddress, countryCode, country AS countryName, state AS regionName, city AS cityName, latitude, longitude, zipCode"))
			->limit(1)
			->get();

		if (count($rows) > 0) {
			$geoData = $rows[0];
			$geoData->statusCode = "OK";
		} else {
			$geoData = (object) null;
			$geoData->statusCode = "ERROR";
		}

		return $geoData;
	}
}
