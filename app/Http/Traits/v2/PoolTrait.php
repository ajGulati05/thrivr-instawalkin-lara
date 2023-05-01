<?php

namespace App\Http\Traits\v2;
//use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Log;
/**
 * This is a generic trait for http requests of Guzzle
 * THIS CLASS MUST BE IMPROVED SOMEHOW
 */
use Illuminate\Support\Facades\Http;
trait PoolTrait
{





public function httpPools( $newArray){

    $fullresponse=collect();


$client = new Client();
  $headers['Content-Type'] = 'application/json';
$requests = function () use ($newArray,$client) {
    for ($i = 0; $i < $newArray->count(); $i++) {
         yield function() use ($client, $newArray,$i) {
            return $client->postAsync( $newArray[$i]->url,[
                        "json" => $newArray[$i]->body,
                        "auth" => ['',$newArray[$i]->key_auth]
                    ]);
        };
    }
};

//Pool of fullfilled
$fullfilled = function ($response, $index) use($fullresponse){
  
$body=$response->getBody()->getContents();
$JSONResponse = json_decode($body, true);

 $fullresponse->push($JSONResponse);
     
         
};
//Pool of rejected
$rejected = function ($reason, $index)  {
    Log::debug("rejected");

};
$pool = new Pool($client, $requests(),['concurrency' => 10, 'fulfilled' => $fullfilled, 'rejected' => $rejected]);
// Initiate the transfers and create a promise
$promise = $pool->promise();
$response = $promise->wait();


return   $fullresponse;
}


}
