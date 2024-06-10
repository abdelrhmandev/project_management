<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WarningEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warning:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email if project has no preparation days or preparation days = the diffrence between current date & updated date';
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
