<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable = ["user_id"];
    protected $casts = ['created_at'  => 'date:Y-m-d'];

    public function User(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function  scopeToday($query){
        return $query->whereRaw('date(' . $this->getTable() . '.created_at) = date(\'' . Carbon::today() . '\')');
    }

    public function  scopeMonth($query){
       
        return $query->whereRaw('LAST_DAY(' . $this->getTable() . '.created_at) = LAST_DAY(\'' . Carbon::now() . '\')');
    }

}
