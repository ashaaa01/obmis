<?php

namespace App\Models; 
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    public function getRouteKeyName()
    {
        return 'name';
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }

        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }

        return false;
    }


    protected $fillable = [
        'name', 'email', 'password', 'pin_code',
    ];

  
    protected $hidden = [
        'pin_code','password', 'remember_token',
    ];

  
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
