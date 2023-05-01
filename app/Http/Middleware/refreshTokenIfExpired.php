<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Auth;
class refreshTokenIfExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       
        $newToken = null;
       
         
         $auth = JWTAuth::parseToken();
     
      
           
         if (! $token = $auth->setRequest($request)->getToken()) {
             
            return response()->json([
                'code' => '401',
                'msg' => 'Authroization time expired'
            ],400);
        }
        
         try {
            
            $user = $auth->authenticate($token);
            if (! $user) {
               Log::error(' Token expired two');
                return response()->json([
                    'code' => '400',
                    'msg' => 'Authorization Failed'
                    
                 ],400);
            }
            $request->headers->set('Authorization','Bearer '.$token);
        } catch (TokenExpiredException $e) {
            try {
                
                $newToken = JWTAuth::refresh($token);
                JWTAuth::setToken($newToken);
            
                $request->headers->set('Authorization','Bearer '.$newToken); // 
               
            } catch (JWTException $e) {
                // 在黑名单的有效期,放行
                if($newToken){
                    $request->headers->set('Authorization','Bearer '.$newToken); // 
                  
                    JWTAuth::setToken($newToken);
                    return $next($request);
                }
                // 过期用户
              
                return response()->json([
                    'code' => '400',
                    'msg' => 'Authorization Failed'
                ],400);
            }
        } catch (JWTException $e) {
           
            return response()->json([
                 'code' => '400',
                    'msg' => 'Authorization Failed'
             ],400);
        }
        $response = $next($request);

        if ($newToken) {
            $response->headers->set('Authorization', 'Bearer '.$newToken);
        }

        return $response;
    }
}
