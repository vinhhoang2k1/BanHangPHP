<?php

namespace App\Models;

use App\Notifications\CustomerResetPasswordNotification;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword ;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Customer extends Model implements CanResetPasswordContract, AuthenticatableContract
{
    use Authenticatable, HasFactory, CanResetPassword, Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAvatarPathAttribute() {
        if (empty($this->attributes['avatar'])) {
            return 'assets/img/avatar/avatar-1.png';
        }

        return 'storage/' . $this->attributes['avatar'];
    }

    public function getEmailForPasswordReset()
    {
        return $this->attributes['email'];
    }

    public function sendPasswordResetNotification($token)
    {
        $url =  'http://fashion-accessories.test/' . 'reset-password/'.$token;

        $this->notify(new CustomerResetPasswordNotification($url));
    }
}
