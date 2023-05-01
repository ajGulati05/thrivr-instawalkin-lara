<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Log;
use Laravel\Passport\Exceptions\OAuthServerException;
use Illuminate\Support\Facades\App;
use Gabievi\Promocodes\Exceptions\InvalidPromocodeException;
use Gabievi\Promocodes\Exceptions\AlreadyUsedException;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [

    ];

    /**
     * Report or log an exception.a
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {

    if ($exception instanceof InvalidPromocodeException ) {

        return response()->json(['errors' => 'Uh oh! The promo code is not valid.','message'=>'Oh oh! The promo code is not valid.','status'=>false], 403);
        //$exception->getMessage()
    }
     if ($exception instanceof SecondUsageInAMonthException ) {

        return response()->json(['errors' => $exception->getMessage(),'message'=>$exception->getMessage(),'status'=>false], $exception->getCode());
        //$exception->getMessage()
    }

      if ($exception instanceof AlreadyUsedException ) {

        return response()->json(['errors' => 'Uh oh! Looks like you have already used that code before.','message'=>'Uh oh! Looks like you have already used that code before.','status'=>false], 403);
        //$exception->getMessage()
    }

      if ($exception instanceof AuthenticationException) {
            return response()->json(['errors'=>'unautenticated','status'=>false], 401);
        }

    if ($exception instanceof OAuthServerException ) {

        return response()->json(['errors' => 'Please make sure your username and password are correct.','message'=>'Please make sure your username and password are correct.','status'=>false], 401);
        //$exception->getMessage()
    }

         if ($exception instanceof ModelNotFoundException) {
        return response()->json([
            'errors' => 'Entry for '.str_replace('App\\', '', $exception->getModel()).' not found','status'=>false], 404);

    }
    if($exception instanceof OAuthServerException)
    {
        return
                   response()->json(['message' => 'You are unauthorized to do that.',"errors"=>'You are unauthorized to do that','staus'=>false], 401);

    }

  if ($request->expectsJson()|| $request->isJson()||$request->wantsJson()) {
    //add Accept: application/json in request

        return $this->handleApiException($request, $exception);
    } else {
        $retval = parent::render($request, $exception);
    }



        if(App::environment('production')){

            if (app()->bound('sentry') && $this->shouldReport($exception)) {
                         app('sentry')->captureException($exception);
                     }
}
             parent::report($exception);

        return $retval;
    }
private function handleApiException($request, Throwable $exception)
{
    $exception = $this->prepareException($exception);






    if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
         Log::debug("HttpResponseException");
        $exception = $exception->getResponse();
    }
    if ($exception instanceof \Illuminate\Validation\ValidationException) {
         Log::debug("ValidationException");
        $exception = $this->convertValidationExceptionToResponse($exception, $request);
    }



    return $this->customApiResponse($exception);
}
     protected function unauthenticated($request, AuthenticationException $exception)
    {

     return response()->json(['message' => 'You are unauthorized to do that.',"errors"=>'You are unauthorized to do that','staus'=>false], 401);
    }



private function customApiResponse($exception)
{


 Log::debug($exception);

    if (method_exists($exception, 'getStatusCode')) {
        $statusCode = $exception->getStatusCode();
    } else {
        $statusCode = 500;
    }

    $response = [];

    switch ($statusCode) {
        case 401:
            $response['message'] = 'Unauthorized';
            break;
        case 403:
            $response['message'] = 'Forbidden';
            break;
        case 404:
            $response['message'] = 'Not Found';
            break;
        case 405:
            $response['message'] = 'Method Not Allowed';
            break;
        case 422:
            $response['message'] = $exception->original['message'];
            $response['errors'] = $exception->original['errors'];
            break;
        default:
            $response['message'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
        break;
    }
    $response['status']=false;
    if (config('app.debug')) {
        //$response['trace'] = $exception->getTrace();
        $response['code'] = $exception->getCode();
    }

    $response['code'] = $statusCode;
     $response['status'] = false;

    return response()->json($response, $statusCode);
}

}


