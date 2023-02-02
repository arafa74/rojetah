<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @method static find($id)
 * @property mixed|string password
 * @property mixed email
 * @property mixed name
 * @property mixed locale
 */
class Admin extends Authenticatable
{
    use Notifiable,hasFactory , HasApiTokens;

    protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
    protected $casts = ['email_verified_at' => 'datetime',
    ];

    public function getLocale(): string
    {
        if($this->locale!=null)
            return $this->locale;
        return "en";
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] =  bcrypt($password);
    }
}
