<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasVerifiedEmail()) {
        
         return view('home');
        }
        return view('auth.verify');
    }

    public function private()
    {
        if (Gate::allows('admin-only',auth()->user())) {
            # code...
        return view('private');
        } else {
            # code...
            abort(403);
        }
    }
}
