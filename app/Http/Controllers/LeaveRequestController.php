<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\LeaveRequest;
use App\Notifications\LeavingRequest;
use App\User;
use Carbon\Carbon;
use Faker\Provider\ar_JO\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use jeremykenedy\LaravelRoles\Models\Role;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = LeaveRequest::query()
        ->join("users AS creator", "leave_requests.creator_id", "creator.id")
        ->leftJoin("users AS approver", "leave_requests.approver_id", "approver.id" )
        ->select("leave_requests.*", "creator.name as creator", "approver.name as approver");
        if($request->from_date){
            $query->whereRaw('date(leave_requests.created_at) between date(\'' .$request->from_date . '\') and  date(\'' .$request->to_date . '\')');
        }
        if(!Auth::user()->hasRole(["admin", "super.admin"])) // not admin
        {
            $query->where('leave_requests.creator_id', Auth::user()->id);
            $arrayOfActions = [];

        }else{
            $arrayOfActions = ["delete", "edit"];
        }
        $creator_column = [
            'name' => 'creator.name',
            'data' => 'creator',
            'title' => __('master.teacher_name'),
        ];

        $approver_column = [
            'name' => 'approver.name',
            'data' => 'approver',
            'title' => __('master.approver'),
        ];
        $status_column = ['title' => __("master.status"), 'data'=> 'status', 'render' => 
        'function(){
            if(this.status == 0)
                return `<span class="badge badge-info">' . __("master.opened") . '</span>`;
            if(this.status == 1)
                return `<span class="badge badge-success">' . __("master.approved") . '</span>`;
            else if (this.status == 2) 
                return `<span class="badge badge-danger">' . __("master.rejected") . '</span>`;
        }'];
        $columns = [ $status_column, $creator_column,$approver_column,
         [ 'title' => __("master.created_at"), 'data'=> 'created_at'],
         [ 'title' => __("master.approved_at"), 'data'=> 'approved_at'],
         [ 'title' => __("master.note"), 'data'=> 'reason']
         
        ];
        $dataTable = new UsersDataTable($columns, $query,[], 'leaverequests', $arrayOfActions );
        return $dataTable->render('dashboard.models.leaverequests.index');
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
    public function store(Request $request)
    {
        if(Auth::user()->hasRole(["admin", "super.admin"]))
        {    
            $id = Auth::user()->id;
            $leaveRequest = LeaveRequest::where('creator_id', $id)
            ->whereRaw('date(created_at) = date(\'' . Carbon::today() . '\')')->first();
            if($leaveRequest){
                Session::flash('message', __("master.you_already_leaving_request")); 
            }else{
                $leaveRequest = LeaveRequest::create(["creator_id" => $id]);
                $users = Role::where("slug", "admin")->first()->users;
                Notification::send($users, new LeavingRequest($leaveRequest));
                Session::flash('message', __("master.you_successfully_leaving_request")); 
                Session::flash('alert-class', 'success'); 
            }
        }
        return redirect()->route("leaverequests.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LeaveRequest  $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveRequest $leaveRequest)
    {
        //
        return redirect()->route("leaverequests.index");

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveRequest  $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveRequest $leaverequest)
    {
        if(Auth::user()->hasRole(["admin", "super.admin"]))
        { 
            return view("dashboard.models.leaverequests.edit", compact("leaverequest"));
        }
        return redirect()->route("leaverequests.index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LeaveRequest  $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveRequest $leaverequest)
    {
        //
        if(Auth::user()->hasRole(["admin", "super.admin"]))
        { 
            $leaverequest->status = $request->status;
            $leaverequest->save();
            $leaverequest->creator->notify(new LeavingRequest($leaverequest));
            return redirect()->route("leaverequests.index");
        }
        return redirect()->route("leaverequests.index");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LeaveRequest  $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Auth::user()->hasRole(["super.admin","admin"]))
            LeaveRequest::where('id', $request->id)->firstOrFail()->delete();
    }
}
