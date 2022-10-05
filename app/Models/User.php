<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        
        $data = [
            'subject' => 'Reset application password',
            'body' => 'You are receiving this email because we received a password reset request for your account.',
            'reset_password' => 'Please reset password',
            'limit' => 'This password reset link will expire in :count minutes.',
            'extras' => 'If you did not request a password reset, no further action is required.',
            'token' => $token,
        ];

        //Notification::send($user,new TestEnrollMent($enrollmentData));
        $this->notify(new \App\Notifications\MailResetPasswordNotification($data));

    }
}
