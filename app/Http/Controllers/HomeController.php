<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Post;
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
    public function dashboard()
    {
        $user  = Auth::user();
        if(!$user){
            return redirect()->route('login');
        }
        if($user->hasRole(['admin', 'super.admin'])){
            return view('dashboard.homepage-admin');
        }
        else if($user->hasRole(['user'])){
             $attendance = Attendance::where('user_id', $user->id)
                ->whereRaw('date(created_at) = date(\'' . Carbon::today() . '\')')->first();
            return view('dashboard.homepage', compact('attendance'));
        }
    }


    public function index()
    {
        
        $latestposts = Post::orderBy("id", 'desc')->limit(10)->get()->toArray();
        $posts = Post::orderBy("id", 'desc')->paginate();

        return view('home', compact('latestposts', 'posts'));
    }

    public function show(Post $post)
    {
        //
        $posts = Post::orderBy("id", 'desc')->limit(10)->get()->toArray();
        return view('dashboard.models.posts.view', compact("post", 'posts'));
    }

    public function showQrcode(){
        return view('dashboard.showQrcode');
    }
}
