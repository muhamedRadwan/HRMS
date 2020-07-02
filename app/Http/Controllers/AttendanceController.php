<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $query = Attendance::query()
        ->join("users","attendances.user_id", "users.id")
        ->select("attendances.created_at", "attendances.id", "users.name");
        $roles_column = [
            'name' => 'users.name',
            'data' => 'name',
            'title' => __('teacher_name'),
        ];
        $columns = [ $roles_column, [ 'title' => __("created_at"), 'data'=> 'created_at']];
        $dataTable = new UsersDataTable($columns, $query);
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
        $attendance = Attendance::where('user_id', $user->id)->whereDate('created_at', Carbonn::today())->first();
        if($attendance){
            Session::flash('message', __("you_already_attended")); 
        }
        $attendance = Attendance::create(["user_id" => $user->id]);
        Session::flash('message', __("you_successfully_attend")); 
        Session::flash('alert-class', 'success'); 

        return view("dashboard.homepage", compact('attendance'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\create_attendance_table  $create_attendance_table
     * @return \Illuminate\Http\Response
     */
    public function show(create_attendance_table $create_attendance_table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\create_attendance_table  $create_attendance_table
     * @return \Illuminate\Http\Response
     */
    public function edit(create_attendance_table $create_attendance_table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\create_attendance_table  $create_attendance_table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, create_attendance_table $create_attendance_table)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\create_attendance_table  $create_attendance_table
     * @return \Illuminate\Http\Response
     */
    public function destroy(create_attendance_table $create_attendance_table)
    {
        //
    }
}
