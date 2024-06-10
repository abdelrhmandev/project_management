<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\GmailCredential;

class ProjectTransaction extends Mailable
{
    use Queueable, SerializesModels;
    protected static $transactionData = [];
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData = [])
	{
		self::$transactionData = $mailData;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$from = GmailCredential::find(1)->email;
		$app_name = config('custom.project_name');

		return $this->markdown('mails.ProjectTransaction')->with('TransData', self::$transactionData)
			->from($from, $app_name)
			->subject(self::$transactionData['project_title'])
			->replyTo('', $app_name);
	}
}
