<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailSent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:emailsent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminder after an hour if user not seen the project';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
