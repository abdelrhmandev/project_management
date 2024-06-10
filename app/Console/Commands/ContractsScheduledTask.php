<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;


class ContractsScheduledTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:contractshandler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete users who have contracts exipred';

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
