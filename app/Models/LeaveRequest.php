<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    //
    protected $fillable = ["creator_id", "approver_id", "status", "reason", "approved_at", "from_time" , "to_time", "note"];
    protected $casts = ['created_at'  => 'date:Y-m-d', 'approve_at' => 'date:Y-m-d'];

    public function creator(){
        return $this->belongsTo('App\User', 'creator_id', 'id');
    }

    public function approver(){
        return $this->belongsTo('App\User', 'approver_id', 'id');
    }

    public function  scopeApproved($query){
        return $query->where('status', 1);
    }

    public function  scopeNotApproved($query){
        return $query->where('status', 0);
    }

    public function  scopeMonth($query){
       
        return $query->whereRaw('LAST_DAY(' . $this->getTable() . '.created_at) = LAST_DAY(\'' . Carbon::now() . '\')');

    }
}
