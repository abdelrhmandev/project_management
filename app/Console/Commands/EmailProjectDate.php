<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailProjectDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:projectemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to every project role if project approve date >= current date';

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
