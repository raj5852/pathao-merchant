<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PathaoController extends Controller
{

    public  function generateToken()
    {
        try {
            $accessToken = self::pathaoAuthorize();
            $accessToken = $accessToken->token_type . ' ' . $accessToken->access_token;
            return $accessToken;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public  function getToken()
    {
        $existance = Storage::disk('local')->exists('pathao_token.json');
        if ($existance) {
            $bearerToken = Storage::get('pathao_token.json');
            $bearerToken = json_decode($bearerToken);
            $bearerToken = $bearerToken[0];
            return ['Authorization' => $bearerToken];
        } else {
            $pathaoAuthorize = self::pathaoAuthorize();
            $accessToken = [$pathaoAuthorize->token_type . ' ' . $pathaoAuthorize->access_token];
            Storage::disk('local')->put('pathao_token.json', json_encode($accessToken));
            return ['Authorization' => $accessToken];
        }
    }


    function citys()
    {

        $base_url = config('app.base_url');
        $access_token = self::getToken();

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->get("$base_url/aladdin/api/v1/countries/1/city-list");

        $responseBody = $response->json(); // Convert the response to JSON

        return $responseBody;
    }


    function getZone($cityId)
    {
        $base_url = config('app.base_url');
        $access_token = self::getToken();
        $city_id = $cityId;

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->get("$base_url/aladdin/api/v1/cities/$city_id/zone-list");

        // You can then handle the response as needed
        $responseBody = $response->json(); // Convert the response to JSON

        return $responseBody;
    }


    function arealist($zoneid = 123)
    {
        $base_url = config('app.base_url');
        $access_token = self::getToken();
        $zone_id = $zoneid; // Replace with the actual zone ID

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->get("$base_url/aladdin/api/v1/zones/$zone_id/area-list");

        // You can then handle the response as needed
        $responseBody = $response->json(); // Convert the response to JSON

       return $responseBody;
    }


    function createStore()
    {

        $base_url = config('app.base_url');
        $access_token = self::getToken();

        // Replace with the actual values for the store
        $storeData = [
            'name' => 'Raj32',
            'contact_name' => 'Manik52',
            'contact_number' => '01852211054',
            'secondary_contact' => '',
            'address' => 'Dhaka Dhaka Dhaka DhakaDhaka',
            'city_id' => '32',
            'zone_id' => '546',
            'area_id' => '2',
        ];

        $response = Http::withHeaders([
            'Authorization' =>  $access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post("$base_url/aladdin/api/v1/stores", $storeData);

        // You can then handle the response as needed
        $responseBody = $response->json(); // Convert the response to JSON

        // Example: Output the response body
        return $responseBody;
    }





    public  function pathaoAuthorize()
    {
        $requestBody = [
            'client_id' => config('app.client_id'),
            'client_secret' => config('app.client_secret'),
            'username' => config('app.client_email'),
            'password' => config('app.password'),
            'grant_type' => config('app.grant_type'),
        ];

        try {
            $base_url = config('app.base_url');
            // Make the POST request
            $response = Http::post("$base_url/aladdin/api/v1/issue-token", $requestBody, [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            return json_decode($response->body());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
