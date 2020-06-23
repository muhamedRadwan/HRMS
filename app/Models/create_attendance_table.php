<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class create_attendance_table extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ["user_id"];

    public function User(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
