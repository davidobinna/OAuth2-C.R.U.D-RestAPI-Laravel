<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class MailResetPasswordNotification extends ResetPassword
{
    use Queueable;
    protected $pageUrl;
    private $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data ;
        parent::__construct($this->data['token']);
        $this->pageUrl = '127.0.0.1:8000';

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {    
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $data = [
            'subject' => 'Reset application password',
            'body' => 'You are receiving this email because we received a password reset request for your account.',
            'reset_password' => 'Please reset password',
            'limit' => 'This password reset link will expire in :count minutes.',
            'extras' => 'If you did not request a password reset, no further action is required.'
        ];
         
         return (new MailMessage)
                ->subject($this->data['subject'])
                ->line($this->data['body'])
                ->action($this->data['reset_password'], $this->pageUrl."?token=".$this->data['token'])
                ->line($this->data['limit'],['count' => config('auth.passwords.users.expire')])
                ->line($this->data['extras']);
            
   //     return (new MailMessage)
     //       ->subject(Lang::getFromJson('Reset application Password'))
       //     ->line(Lang::getFromJson('You are receiving this email because we received a password reset request for your account.'))
         //   ->action(Lang::getFromJson('Reset Password'), $this->pageUrl."?token=".$this->token)
           // ->line(Lang::getFromJson('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]))
           // ->line(Lang::getFromJson('If you did not request a password reset, no further action is required.'));

     } 

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
