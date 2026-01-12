<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Events\WelcomeMail;
use Illuminate\Http\Request;
use App\User;
use Socialite;
use App\Email;

class AuthController extends Controller{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(){
        return redirect()->route('index-home');
        return view('auth.index');
    }
}