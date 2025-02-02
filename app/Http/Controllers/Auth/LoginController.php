<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.login', [
            'page_title' => 'Login'
        ]);
    }

    public function authenticate(Request $request) {
        
    }
}
