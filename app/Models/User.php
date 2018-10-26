<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 * @property integer id
 * @property object avatar
 * @property string email
 * @property string password
 * @property string token
 * @property string api_token
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar',
        'email',
        'password',
        'token',
        'api_token',
    ];

    protected $casts = [
        'avatar' => 'json'
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
     * @param null $password
     * @return string
     */
    public function setPasswordAttribute($password = null)
    {
        return $this->attributes['password'] = bcrypt($password);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|OauthAccessToken[]
     */
    public function oAuthTokens()
    {
        return $this->hasMany(OauthAccessToken::class);
    }
}
