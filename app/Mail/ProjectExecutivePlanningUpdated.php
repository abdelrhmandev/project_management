<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\GmailCredential;

class ProjectExecutivePlanningUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
      public static $mailData;
     public function __construct($mailData = [])
	{
		self::$mailData = $mailData;
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

		return $this->markdown('mails.ProjectExecutivePlanningUpdated')->with('PData', self::$mailData)
			->from($from, $app_name)
			->subject(self::$mailData['project_title'])
			->replyTo('', $app_name);
	}
    
}
