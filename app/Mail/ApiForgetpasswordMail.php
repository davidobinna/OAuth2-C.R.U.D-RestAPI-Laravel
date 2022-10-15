<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApiForgetpasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $usersubject;
    public $useremail;
    public $usertoken;
    public $userpageUrl;
    public $link ;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->usersubject = $data['subject'];
        $this->useremail = $data['email'];
        $this->usertoken = $data['token'];
        $this->userpageUrl = "http://127.0.0.1:8000/api/resetpassword";
        $this->link = $this->userpageUrl."?token=".$this->usertoken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forgotpassword')
        ->subject($this->usersubject);
        //->action($this->subject, $this->pageUrl."?token=".$this->usertoken);

    }
}
