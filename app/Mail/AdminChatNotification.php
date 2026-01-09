<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminChatNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;

    public function __construct(Message $msg)
    {
        $this->msg = $msg;
    }

    public function build()
    {
        return $this->subject('Ada Pesan Baru dari User!')
                    ->view('emails.chat_notification');
    }
}
