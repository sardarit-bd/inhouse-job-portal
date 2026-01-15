<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactMessage;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $adminReply;

    public function __construct(ContactMessage $message, $adminReply)
    {
        $this->message = $message;
        $this->adminReply = $adminReply;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Re: ' . $this->message->subject)
                    ->view('emails.contact.reply')
                    ->with([
                        'contactMessage' => $this->message,
                        'adminReply' => $this->adminReply,
                    ]);
    }
}