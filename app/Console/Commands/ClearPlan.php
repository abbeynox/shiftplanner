<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\Shift;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;

class ClearPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schichtplan:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all passed plans without activity in the last 30 days.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $timeGiotine = new \DateTime('1 month ago');

        // Remove shifts which are older than one month
        Shift::where('start', '<', $timeGiotine)
            ->orWhere('end', '<', $timeGiotine)
            ->delete();

        // Remove all plans older than one month without shifts
        Plan::where('updated_at', '<', $timeGiotine)
            ->doesnthave('shifts')
            ->delete();

        return Command::SUCCESS;
    }
}
