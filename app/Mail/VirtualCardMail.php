<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\GmailCredential;

class VirtualCardMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private static $cardData;

    public function __construct(...$mailData)
    {
        self::$cardData = $mailData;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        $from = GmailCredential::find(1)->email;
        $app_name = config('custom.project_name');

        return new Envelope(
            from: new Address($from, $app_name),
            replyTo: [
                new Address($from, $app_name),
            ],
            subject: 'بطاقة بريدية - ' . self::$cardData[2]
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.ResearcherVirtualCard',
            with: [
                'cardData' => self::$cardData
            ],
        );
    }

}
