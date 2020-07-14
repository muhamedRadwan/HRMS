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
use Yajra\DataTables\Html\Button;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buttons = [];
        $query = LeaveRequest::query()
        ->join("users AS creator", "leave_requests.creator_id", "creator.id")
        ->leftJoin("users AS approver", "leave_requests.approver_id", "approver.id" )
        ->select("leave_requests.*", "creator.name as creator", "approver.name as approver");
        if($request->from_date){
            $query->whereRaw('date(leave_requests.created_at) between date(\'' .$request->from_date . '\') and  date(\'' .$request->to_date . '\')');
        }
        if(!Auth::user()->hasRole(["admin", "super.admin"])) // not admin
        {
            $buttons[] = Button::make('create')->name(__("master.create"));
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
        $from_time_column = ['title' => __("master.from"), 'data'=> 'from_time', 'render' => 
        'function(){
                if(this.from_time && this.to_time)
                    return   moment(`${this.from_time}`).format("YYYY-MM-DD hh:mm A") 
                return "";
        }'];
        $to_time_column = ['title' => __("master.to"), 'data'=> 'to_time', 'render' => 
        'function(){
                if(this.from_time && this.to_time)
                    return   moment(`${this.to_time}`).format("YYYY-MM-DD hh:mm A") ;
                return "";
        }'];
        $columns = [ $status_column, $creator_column,$approver_column,$from_time_column,$to_time_column,
         [ 'title' => __("master.approved_at"), 'data'=> 'approved_at'],
         [ 'title' => __("master.note"), 'data'=> 'note']
         
        ];
        $dataTable = new UsersDataTable($columns, $query,$buttons, 'leaverequests', $arrayOfActions );
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
        return view("dashboard.models.leaverequests.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo $request->from_time;
        // dd( date('Y-m-d h:i A', strtotime($request->to_time)));
        // dd( date($request->to_time));
        
        $validatedData = $request->validate([
            'from_time'      => 'required',
            'to_time'       => 'required',
        ]);
        
        if(Auth::user()->hasRole(["user"]))
        {    
            $id = Auth::user()->id;
            // $leaveRequest = LeaveRequest::where('creator_id', $id)
            // ->whereRaw('date(created_at) = date(\'' . Carbon::today() . '\')')->first();
            $leaveRequest = LeaveRequest::create([
                "from_time" => $request->from_time, 
                "to_time" => date($request->to_time), 
                "note" => $request->note, 
                "creator_id" => $id]
            );
            $users = Role::where("slug", "admin")->first()->users;
            Notification::send($users, new LeavingRequest($leaveRequest));
            Session::flash('message', __("master.you_successfully_leaving_request")); 
            Session::flash('alert-class', 'success'); 
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
            $request->session()->flash('message', __('master.edited_successfully'));
            $request->session()->flash('alert-class', 'success');
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
