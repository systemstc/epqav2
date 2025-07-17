<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use DateTime;
use DateTimeZone;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use Mail;
use Session;
use DB;
use App\Models\User;
use App\Models\Query;
use App\Models\Firm;
use App\Models\Branch;
use App\Models\Director;
use App\Models\Notes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Helper {


    protected static $client;
    protected static $apiKey;

    public static function init()
    {
        self::$client = new Client([
            'verify' => 'C:/wamp64/cacert.pem', // Path to your cacert.pem file
            'headers' => [
                'User-Agent' => 'epqav2 (systems.tc@gmail.com)',
            ],
        ]);
    }

	public static function isCustomerVerified($email)
	{
		$user = User::select('email_verified_at','email_verified_received_at','id','email','user_type')->where('email',$email)->first();
		return $user;
	}

	public static function getUserDetailbyEmail($email)
	{
         $user = User::select('*')->where('email',$email)->first();
         return $user;
	}	

	public static function getFirmDetailById($id)
	{
         // $application = Firm::with(['branches', 'directors', 'querys','renewals'])->findOrFail($id);
			$application = Firm::with([
			    'branches' => function ($query) {
			        $query->where('status', '1');
			    },
			    'directors' => function ($query) {
			        $query->where('status', '1');
			    },
			    'querys',
			    'renewals',
			    'notes'
			])->findOrFail($id);
         return $application;

	}	
	public static function getFirmDetailByUserId($id)
	{
		// return $id;
         // $application = Firm::with(['branches', 'directors','querys','renewals'])->where('firms.user_id', $id)->first();
		$application = Firm::with([
		    'branches' => function ($query) {
		        $query->where('status', '1');
		    },
		    'directors' => function ($query) {
		        $query->where('status', '1');
		    },
		    'querys',
		    'renewals',
		    'notes'
		])->where('user_id', $id)->orderBy('id', 'desc')->first();
         return $application;

	}

	public static function getLatLng($address) {
		// // bb1cc7fd62534b74b5d5fae5be38968e
		// // return urlencode($address);
	 //    $url = 'https://nominatim.openstreetmap.org/search?q=' . urlencode($address) . '&format=json&limit=1';
	 //    // return $url;

	 //    $ch = curl_init();
	 //    // return $ch;
	 //    curl_setopt($ch, CURLOPT_URL, $url);
	 //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 //    curl_setopt($ch, CURLOPT_USERAGENT, "epqav2 (systems.tc@gmail.com)");
	 //    // curl_setopt($ch, CURLOPT_CAINFO, "C:/wamp64/bin/php/php8.3.6/cacert.pem"); 
	 //    $certificate_location = "C:\wamp64\cacert.pem"; // modify this line accordingly (may need to be absolute)
		// // curl_setopt($ch, CURLOPT_CAINFO, $certificate_location);
	 //    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		// // curl_setopt($ch, CURLOPT_CAPATH, $certificate_location);
	 //    $response = curl_exec($ch);
	 //    // return $response;
	 //    if (curl_errno($ch)) {
		//     // Handle cURL error
		//     $error_msg = curl_error($ch);
		//     return $error_msg;
		//     // You might want to log or display this error message
		// }

	 //    curl_close($ch);

	 //    $data = json_decode($response, true);
	 //    // return $data;

	 //    if (!empty($data)) {
	 //        $location = $data[0];
	 //        return ['lat' => $location['lat'], 'lon' => $location['lon']];
	 //    } else {
	 //        return false; // Handle the error as needed
	 //    }
		self::init();

		 // $response = self::$client->get('https://api.opencagedata.com/geocode/v1/json', [
   //          'query' => [
   //              'q' => $address,
   //              'key' => 'bb1cc7fd62534b74b5d5fae5be38968e',
   //          ],
   //      ]);		 
		$url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($address) . "&format=json&limit=1";
		 $response = self::$client->get($url);

        $data = json_decode($response->getBody(), true);
        // return $data;

        if (isset($data[0])) {
            return [
                'lat' => $data[0]['lat'],
                'lon' => $data[0]['lon'],
            ];
        }

        // return null;
	}

}