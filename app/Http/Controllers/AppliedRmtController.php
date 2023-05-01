<?php

namespace App\Http\Controllers;

use App\AppliedRmt;
use Illuminate\Http\Request;

class AppliedRmtController extends Controller
{
    


      /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {

      $this->validate(request(), [
               'firstname' => 'required|min:2',
               'lastname' => 'required|min:2',
               'businessname' => 'required|min:2',
               'address' => 'required|min:2',
               'city' => 'required|min:2',
               'province' => 'required|min:2',
               'postalcode' => 'required|min:2',
               'city' => 'required|min:2',
               'website' => 'required|email',
               'phone' => 'required|min:2'
          ]);

          $contactForm = ContactForm::Create([

               'name' => request('name'),
               'phone' => '13062625152',
               'email' => request('email'),
               'comment' => request('comment')

          ]);



        return redirect('/contact-us');
       //  return response()->json(['response'=>true]);      
     }


       /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function addSelf(Request $request)
     {

      $this->validate(request(), [
               'name' => 'required|min:2',
               'email' => 'required|email',
               'comment' => 'required|min:2'.
               'firstname'=>'required|min:2'
          ]);

          $contactForm = ContactForm::Create([

               'name' => request('name'),
               'phone' => '13062625152',
               'email' => request('email'),
               'comment' => request('comment')

          ]);


       

        return redirect('/contact-us');
       //  return response()->json(['response'=>true]);      
     }

       /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function addARMT(Request $request)
     {

      $this->validate(request(), [
               'name' => 'required|min:2',
               'email' => 'required|email',
               'comment' => 'required|min:2'
          ]);

          $contactForm = ContactForm::Create([

               'name' => request('name'),
               'phone' => '13062625152',
               'email' => request('email'),
               'comment' => request('comment')

          ]);



        return redirect('/contact-us');
       //  return response()->json(['response'=>true]);      
     }
}
