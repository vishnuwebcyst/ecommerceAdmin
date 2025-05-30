<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $username;

    protected $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $link)
    {
        $this->username = $username;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.forgot-password', ['link' => $this->link, 'username' => $this->username]);
    }
}
