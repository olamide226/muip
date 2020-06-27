<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user()->user_status;
        // $user_status = $request->user();
        if ($user != 'V') {
            
            return redirect()->intended('payment');
        }
        return view('home')->withUser($user);
    }
}
