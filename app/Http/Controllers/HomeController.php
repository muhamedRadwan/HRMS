<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use stdClass;

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
            $attendance = new stdClass();
            $attendance->today = Attendance::today()->count();
            $attendance->month = Attendance::month()->count();
            $daysInMonth = Carbon::now()->daysInMonth;
            $allTeacher = User::allTeacher()->count();
            if( $allTeacher){
                $attendance->precentage_today  =   100 - (($allTeacher -  ($attendance->today) ) / $allTeacher * 100);
                $allTeacherInMonth = $allTeacher * $daysInMonth; // Number Of Attendance
                $attendance->precentage_month  =   100 - (($allTeacherInMonth -  ($attendance->month) ) / $allTeacherInMonth * 100);
            }else{
                $attendance->precentage_today = 0;
                $attendance->precentage_month = 0;
            }
            
            $LeaveRequest = new stdClass();
            $LeaveRequest->approved = LeaveRequest::month()->approved()->count();
            $LeaveRequest->notApproved = LeaveRequest::month()->notApproved()->count();
            $LeaveRequestTotal = LeaveRequest::month()->count();
            if($LeaveRequestTotal){
                $LeaveRequest->precentage_approved  =   100 - (($LeaveRequestTotal -  ($LeaveRequest->approved) ) / $LeaveRequestTotal * 100);
                $LeaveRequest->precentage_notApproved  =   100 - (($LeaveRequestTotal -  ($LeaveRequest->notApproved) ) / $LeaveRequestTotal * 100);
            }else{
                $LeaveRequest->precentage_approved = 0;
                $LeaveRequest->precentage_notApproved = 0;
            }
            return view('dashboard.homepage-admin', compact('attendance', 'LeaveRequest'));
        }
        else if($user->hasRole(['user'])){
             $attendance = Attendance::select("created_at", "leave_at")->where('user_id', $user->id)
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
