<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user  = Auth::user();
        if($user  && $user->hasRole(['admin', 'super.admin'])){
            return view('dashboard.homepage-admin');
        }
        else if($user  && $user->hasRole(['user'])){
             $attendance = Attendance::where('user_id', $user->id)
                ->whereRaw('date(created_at) = date(\'' . Carbon::today() . '\')')->first();
            return view('dashboard.homepage', compact('attendance'));
        }else{
            return view('home');
        }
    }

}
