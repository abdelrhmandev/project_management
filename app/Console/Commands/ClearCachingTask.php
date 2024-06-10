<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCachingTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:clearappcaching';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear application cache,route cache,config cache,view cache';

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
