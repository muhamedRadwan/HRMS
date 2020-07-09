<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class ChartsController extends Controller
{
    //
    public function getAttendance(){
        $Object = new stdClass();
        $Object->Attendance = Attendance::selectRaw("count(attendances.id) as data,
                 months.name, months.month_number")
            ->rightJoin("months", "month_number", '=',DB::raw("MONTH(attendances.created_at)"))
            ->orderBy("month_number", "ASC")->groupBy("months.name", "month_number")->get();
        
        $Object->LeaveRequestApproved = LeaveRequest::selectRaw("count(leave_requests.id) as data, 
                 months.month_number")
                ->rightJoin('months', function ($join) {
                    $join->on('month_number', '=', DB::raw("MONTH(leave_requests.created_at)"))
                         ->where('status', '=', 1);
                })
            // ->rightJoin("months", "month_number", '=',DB::raw("MONTH(leave_requests.created_at)"))
            ->orderBy("month_number", "ASC")->groupBy("month_number")->get();

        $Object->LeaveRequestNotApproved = LeaveRequest::selectRaw("count(leave_requests.id) as data, 
             months.month_number")
        ->rightJoin('months', function ($join) {
            $join->on('month_number', '=', DB::raw("MONTH(leave_requests.created_at)"))
                 ->where('status', '=', 0);
            })        
        ->orderBy("month_number", "ASC")->groupBy("month_number")->get();  
        return response()->json($Object);
    }
}
