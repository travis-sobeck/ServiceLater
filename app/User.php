<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin', 'email', 'password', 'name'
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
    ];

    public static function boot()
    {
        parent::boot();
         self::created(function(User $user){
            $assignmentGroup = \App\AssignmentGroup::where("group_name", "Sample Group")->firstOrFail();
            $user->assignmentGroups()->attach($assignmentGroup->id);
            $user->save();
        });

    }

    public function assignmentGroups()
    {
        return $this->belongsToMany('App\AssignmentGroup')->orderBy('group_name');
    }
}
