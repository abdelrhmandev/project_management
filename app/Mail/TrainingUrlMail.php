<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrainingUrlMail extends Mailable
{
	use Queueable, SerializesModels;
	protected $mailData = [];

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($mailData = [])
	{
		$this->mailData = $mailData;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$from = \App\Models\GmailCredential::find(1)->email;
		$app_name = config('custom.project_name');

		return $this->markdown('mails.TrainingUrl')->with('mailData', $this->mailData)
			->from($from, $app_name)
			->subject($this->mailData['title'])
			->replyTo('', $app_name);
	}
}
