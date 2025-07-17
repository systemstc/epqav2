<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Renewal;

class ReminderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $renewal;

    public function __construct(Renewal $renewal)
    {
        $this->renewal = $renewal;
    }

    public function build()
    {
        return $this->subject('Your Application is About to Expire')
                    ->view('emails.reminder_notification');
    }

    // /**
    //  * Create a new message instance.
    //  */
    // public function __construct()
    // {
    //     //
    // }

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Reminder Notification',
    //     );
    // }

    // *
    //  * Get the message content definition.
     
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
