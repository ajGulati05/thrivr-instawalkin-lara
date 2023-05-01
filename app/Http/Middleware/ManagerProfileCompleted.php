<?php

namespace App\Http\Middleware;

use Closure;
use App\Manager;
class ManagerProfileCompleted
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
        $this->hasLocation($request,$next);
        
         // $this->hasLocation($request,$next);
        return $next($request);
    }

    

    public function hasLocation($request, Closure $next)
    {
        $manager=Manager::where('id','=',auth('webmanager')->user()->id)->first()->locations;
        //dd($manager);
     if ( empty ($manager))
     {
           return redirect()->route('locations.create')->send();
     }
      $this->hasEmployees($request,$next);

    }


   

      public function hasEmployees($request, Closure $next)
    {
             $manager=Manager::where('id','=',auth('webmanager')->user()->id)->first()->employees;

       
     if ( empty ($manager)) 
     {
           return redirect()->route('employees.create')->send();
     }
     else if($manager->count()<1)
      {
           return redirect()->route('employees.create')->send();
     }
     $this->hasServices($request,$next);

    }

       public function hasServices($request, Closure $next)
    {
             $manager=Manager::where('id','=',auth('webmanager')->user()->id)->first()->services;
     
     if ( $manager->count()<1)
     {

           return redirect()->route('services.create')->send();
     }

    }
}
