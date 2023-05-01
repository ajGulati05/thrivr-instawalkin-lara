<?php

namespace App\Http\Controllers\Managersapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
            return view('managersapi.app');
    }
}
