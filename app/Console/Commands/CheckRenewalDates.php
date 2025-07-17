<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Renewal;
use App\Models\Firm;
use App\Mail\ExpirationNotification;
use App\Mail\ReminderNotification;
use Carbon\Carbon;

class CheckRenewalDates extends Command
{
    // protected $signature = 'check:renewal-dates';
    // protected $description = 'Check renewal dates and send emails if necessary';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-renewal-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check renewal dates and send emails if necessary';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();
        $nextWeek = $today->copy()->addWeek();

        // Check for expired renewals
        $expiredRenewals = Renewal::whereDate('renewals.expired_date', '<=', $today)
        ->leftjoin('firms','renewals.firm_id','=','firms.id')
        ->get();
        foreach ($expiredRenewals as $renewal) {
            $update = Firm::where('id',$renewal->firm_id)->update([
                'status' => '50'
            ]);
            Mail::to($renewal->email)->send(new ExpirationNotification($renewal));
        }

        // Check for renewals expiring in the next 7 days
        $upcomingRenewals = Renewal::whereBetween('renewals.expired_date', [$today, $nextWeek])
        ->leftjoin('firms','renewals.firm_id','=','firms.id')
        ->get();

        foreach ($upcomingRenewals as $renewal) {
            Mail::to($renewal->email)->send(new ReminderNotification($renewal));
        }

        $this->info('Renewal dates checked and notifications sent.');
    }
    
}
