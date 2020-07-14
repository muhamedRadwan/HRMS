<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = Attendance::query()
        ->join("users","attendances.user_id", "users.id")
        ->select("attendances.created_at", "attendances.id", "users.name", "attendances.leave_at");
        if($request->from_date){
            $query->whereRaw('date(attendances.created_at) between date(\'' .$request->from_date . '\') and  date(\'' .$request->to_date . '\')');
        }
        $roles_column = [
            'name' => 'users.name',
            'data' => 'name',
            'title' => __('master.teacher_name'),
        ];
        $created_at_Column = [ 'title' => __("master.created_at"),
             'data'=> 'created_at', 'render' => 'function(){
                if(this.created_at)
                    return   moment(this.created_at).format("[' . __("master.day") . '] DD-MM-YYYY [' . __("master.hours") . '] HH:mm A");
                return "";
                }'
        ];
        $leave_at_Column = [ 'title' => __("master.leave_at"),
             'data'=> 'leave_at', 'render' => 'function(){
                if(this.leave_at)
                    return moment(this.leave_at).format("[' . __("master.day") . '] DD-MM-YYYY [' . __("master.hours") . '] HH:mm A");
                return "";
                }'
        ];
        $columns = [ $roles_column, $created_at_Column, $leave_at_Column];
        $arrayOfActions = ["delete"];
        $dataTable = new UsersDataTable($columns, $query,[], 'attendance', $arrayOfActions );
        return $dataTable->render('dashboard.models.attendance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($token, Request $request)
    {
        $user = User::where("token", $token)->firstOrFail();
        $attendance = Attendance::where('user_id', $user->id)
        ->whereRaw('date(created_at) = date(\'' . Carbon::today() . '\')')->first();
        if($attendance && $attendance->leave_at){
            Session::flash('message', __("master.you_already_attended")); 
        }
        else if( $attendance && !$attendance->leave_at){// second Time Leave
            $attendance->leave_at  = now();
            $attendance->save();
            Session::flash('message', __("master.you_successfully_leave")); 
            Session::flash('alert-class', 'success');
        } else if(!$attendance){ // First Time Attendance
            $attendance = Attendance::create(["user_id" => $user->id]);
            Session::flash('message', __("master.you_successfully_attend")); 
            Session::flash('alert-class', 'success'); 
        }
        return redirect()->route("home-guest");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $Attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $Attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $Attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $Attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $Attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $Attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if(Auth::user()->hasRole(["super.admin","admin"]))
            Attendance::where('id', $request->id)->firstOrFail()->delete();
        
    }

    // Json Chart 

}
