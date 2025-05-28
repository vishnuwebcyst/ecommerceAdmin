<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $username;
    protected $link;
    protected $msg;
    protected $items;
    protected $grand_total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $link, $msg, $items, $grand_total)
    {
        $this->username = $username;
        $this->link = $link;
        $this->msg = $msg;
        $this->items = $items;
        $this->grand_total = $grand_total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.order', ['username' => $this->username, 'msg' => $this->msg, 'link' => $this->link, 'items' => $this->items, 'grand_total' => $this->grand_total]);
    }
}
