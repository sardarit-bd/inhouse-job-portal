<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactMessage;

class ContactAutoReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public function __construct(ContactMessage $message)
    {
        $this->message = $message;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Thank you for contacting ' . config('app.name'))
                    ->view('emails.contact.auto-reply')
                    ->with([
                        'message' => $this->message,
                    ]);
    }
}