<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = ["title", "body", "image", "user_id"];
    protected $casts = ['created_at'  => 'date:Y-m-d'];

    /**
     * Get the User that owns the Notes.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

}
