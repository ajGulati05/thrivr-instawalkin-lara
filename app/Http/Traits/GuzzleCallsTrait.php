<?php

namespace App\Http\Traits;

use App\GuzzleRequest;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;
/**
 * This is a generic trait for http requests of Guzzle
 * THIS CLASS MUST BE IMPROVED SOMEHOW
 */
trait GuzzleCallsTrait
{
    public function guzzlePost(GuzzleRequest $request)
    {


        try {
            $client = new \GuzzleHttp\Client();

            $url = $request->url;
            $body = $request->body;
            $headers['Content-Type'] = 'application/json';
            if ($request->username_auth == null && $request->key_auth == null) {
                
                $response = $client->post(
                    $url,
                    [
                        "json" => $body,
                        "headers" => $headers,
                        // "verify"=>false
                    ]
                );
              
            } else {
                $username_auth = $request->username_auth;
                $key_auth = $request->key_auth;
                $response = $client->post(
                    $url,
                    [
                        "json" => $body,
                        "headers" => $headers,
                        "auth" => [$username_auth, $key_auth]
                    ]
                );
            }
             
            $body = $response->getBody()->getContents();
            $JSONResponse = json_decode($body, true);
             return $JSONResponse;
   }
 
    catch (BadResponseException $ex) {

   
   
    $reason=$ex->getResponse()->getBody(true)->getContents();
   
    $statuscode=$ex->getResponse()->getStatusCode();
    abort($statuscode, $reason );
}
    }

    public function guzzleGet(GuzzleRequest $request)
    {

         try {
        $client = new \GuzzleHttp\Client();
        $url = $request->url;
        $body = $request->body;
        $headers['Content-Type'] = 'application/json';

        if ($request->username_auth == null && $request->key_auth == null) {
            $response = $client->get(
                $url,
                [
                    "json" => $body,
                    "headers" => $headers,
                    // "verify"=>false
                ]
            );
        } else {
            $username_auth = $request->username_auth;
            $key_auth = $request->key_auth;
            $response = $client->get(
                $url,
                [
                    "json" => $body,
                    "headers" => $headers,
                    "auth" => [$username_auth, $key_auth]
                ]
            );
        }
        $body = $response->getBody()->getContents();
        $JSONResponse = json_decode($body, true);

        return $JSONResponse;}

        catch (BadResponseException $ex) {
     
    $reason=$ex->getResponse()->getBody(true)->getContents();
    $decodedErrorMessage=json_decode($reason,true)['message'];
    $statuscode=$ex->getResponse()->getStatusCode();
    abort($statuscode, $decodedErrorMessage );
}
    }

    public function guzzleDelete(GuzzleRequest $request)
    {

        try{
        $client = new \GuzzleHttp\Client();
        $url = $request->url;
        $body = $request->body;
        $headers['Content-Type'] = 'application/json';

        if ($request->username_auth == null && $request->key_auth == null) {
            $response = $client->delete(
                $url,
                [
                    "json" => $body,
                    "headers" => $headers,
                    // "verify"=>false
                ]
            );
        } else {
            $username_auth = $request->username_auth;
            $key_auth = $request->key_auth;
            $response = $client->delete(
                $url,
                [
                    "json" => $body,
                    "headers" => $headers,
                    "auth" => [$username_auth, $key_auth]
                ]
            );
        }
        $body = $response->getBody()->getContents();
        $JSONResponse = json_decode($body, true);

        return $JSONResponse;}
        catch (BadResponseException $ex) {
    
    $reason=$ex->getResponse()->getBody(true)->getContents();
    $decodedErrorMessage=json_decode($reason,true)['message'];
    $statuscode=$ex->getResponse()->getStatusCode();
    abort($statuscode, $decodedErrorMessage );
}  
    }
    public function guzzlePut(GuzzleRequest $request)
    {
        try{
        $client = new \GuzzleHttp\Client();
        $url = $request->url;
        $body = $request->body;
        $headers['Content-Type'] = 'application/json';

        if ($request->username_auth == null && $request->key_auth == null) {
            $response = $client->put(
                $url,
                [
                    "json" => $body,
                    "headers" => $headers,
                    // "verify"=>false
                ]
            );
        } else {
            $username_auth = $request->username_auth;
            $key_auth = $request->key_auth;
            $response = $client->put(
                $url,
                [
                    "json" => $body,
                    "headers" => $headers,
                    "auth" => [$username_auth, $key_auth]
                ]
            );
        }
        $body = $response->getBody()->getContents();
        $JSONResponse = json_decode($body, true);

        return $JSONResponse;
    }
          catch (BadResponseException $ex) {
   
    $reason=$ex->getResponse()->getBody(true)->getContents();
    $decodedErrorMessage=json_decode($reason,true)['message'];
    $statuscode=$ex->getResponse()->getStatusCode();
    abort($statuscode, $decodedErrorMessage );
}
    }
}
