<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct($pdfPath)
    {
        $this->pdfPath = $pdfPath;
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Your Certificate',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: $this->view('emails.certificate'),
    //         // view: 'view.name',
    //     );
    // }

    public function build()
    {
        return $this->markdown('emails.certificate')
            ->subject('Your Certificate')
            ->attach($this->pdfPath, [
                'as' => 'certificate.pdf',
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [
    //             'path' => $this->pdfPath,
    //             // 'as' => 'certificate.pdf',
    //             // 'mime' => 'application/pdf',      
    //     ];
    // }
}
