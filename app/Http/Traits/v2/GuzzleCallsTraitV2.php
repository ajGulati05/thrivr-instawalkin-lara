<?php

namespace App\Http\Traits\v2;
use Illuminate\Http\Request;
use App\GuzzleRequest;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

/**
 * This is a generic trait for http requests of Guzzle
 * THIS CLASS MUST BE IMPROVED SOMEHOW
 */
use Illuminate\Support\Facades\Http;
trait GuzzleCallsTraitV2
{


    public function returnAPIResponseJSON($type,Request $request){
        $response=$this->makeHttpRequest($type,$request);


         return response()->json(["data"=>$response->json()['data'],"status"=>true],200);
          
    }

    public function returnResponseJSON($type,Request $request){
        $response=$this->makeHttpRequest($type,$request);
   
        return $response->json();

    }

    public  function makeHttpRequest($type,Request $request){


        if($type==config('enum.httpRequests.get'))
             {
                 
                $response=$this->httpGet($request);
            }
         elseif ($type==config('enum.httpRequests.post')) {
           
             $response=$this->httpPost($request);
            }   
        elseif ($type==config('enum.httpRequests.put')) {
              $response=$this->httpPut($request);
            }    
        elseif ($type==config('enum.httpRequests.delete')) {
                    $response=$this->httpDelete($request);
            }    
             elseif ($type==config('enum.httpRequests.httpPutWithoutBody')) {
                    $response=$this->httpPutWithoutBody($request);
            }        

            if($response->failed())
        {
            Log::critical("Timekit error". $request);
            Log::critical($response);

            abort(response()->json(["errors"=>"Uh oh! Looks like someone just snagged that spot. We are sorry about that.","message"=>'Uh oh! Looks like someone just snagged that spot. We are sorry about that.',"status"=>false],$response->status()));
        }
        return $response;
    }
    public function httpPost(Request $request)
    {
  

    $response = Http::withHeaders([
    'Content-Type' => 'application/json'])
        ->withBasicAuth('',$request->key_auth)
        ->post( $request->url,

            $request->body
        );   

        return $response;

    }

    public function httpGet(Request $request)
    {


        $response = Http::withHeaders([
    'Content-Type' => 'application/json'])
        ->withBasicAuth('',$request->key_auth)
        ->get( $request->url);   
//for error messages
               //  Log::debug("json".$response->json());
        return $response;
        
    }

    public function httpDelete(Request $request)
    {


        $response = Http::withHeaders([
    'Content-Type' => 'application/json'])
        ->withBasicAuth('',$request->key_auth)
        ->delete( $request->url);   
        return $response;
        
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
    public function httpPut(Request $request)
{
  

 $response = Http::withHeaders([
        'Content-Type' => 'application/json'])
         ->withBasicAuth('',config('constants.configurations.timekit_dev_key'))
        ->put( $request->url,$request->body
             
        );   


  return $response;
    }

    public function httpPutWithoutBody(Request $request)
{
  

 $response = Http::withHeaders([
        'Content-Type' => 'application/json'])
         ->withBasicAuth('',config('constants.configurations.timekit_dev_key'))
        ->put( $request->url
             
        );   


  return $response;
    }
}
