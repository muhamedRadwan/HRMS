<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoleAndPermission;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'  => 'date:Y-m-d'
    ];
    
    /**
     * Get the notes for the users.
     */
    public function notes()
    {
        return $this->hasMany('App\Models\Notes');
    }

    /**
     * Get the notes for the users.
     */
    public function roles()
    {
        return $this->belongsToMany('jeremykenedy\LaravelRoles\Models\Role');
    }
}
