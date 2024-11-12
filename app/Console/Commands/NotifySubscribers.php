<?php

namespace App\Console\Commands;

use App\Models\Shift;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NotifySubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schichtplan:notify-subscribers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify subscribers 1 day before theire shift';

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
     * todo: merge with the sendReminder function
     *
     * @return int
     */
    public function handle()
    {
        $done = [];
        // get all shifts we want to notify
        $toNotify = Shift::whereDate('start', '<=', date('Y-m-d', strtotime('+1 day')))
          ->where('notified', '<>', '1')->get();
        foreach ($toNotify as $shift) {
            $planId = $shift->plan->id;
            if (!isset($done[$planId])) {
                $done[$planId] = [];
            }
            if (\Illuminate\Support\Facades\Date::parse($shift->start) > \Illuminate\Support\Facades\Date::now()) {
              foreach ($shift->subscriptions as $sub) {
                  if ($sub->notification) {
                      if (!isset($done[$planId][$sub->email])) {
                          $sub->sendReminder();
                          $done[$planId][$sub->email] = true;
                      }
                  }
              }
            }
            $shift->notified = true;
            $shift->save();
        }
        return Command::SUCCESS;
    }
}
