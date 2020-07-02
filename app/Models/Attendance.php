<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ["user_id"];
    protected $casts = ['created_at'  => 'date:Y-m-d'];

    public function User(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
