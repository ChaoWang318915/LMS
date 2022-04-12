<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Auth;
use App\Models\Auth\User;

class StripeCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripecronjob:stripecronjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every day Running for checking the billing date';

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
     * @return mixed
     */
    public function handle()
    {
         $users = User::all();
         foreach($users as $user){
             if(Carbon::today()->format('Y-m-d') == Carbon::parse($user->bill_date)->format('Y-m-d')){
                 $user->paid_check = 2;
                 $user->start_date = Carbon::today()->format('Y-m-d 00:00:00');
                 $user->bill_date = Carbon::today()->addDays(31)->format('Y-m-d 00:00:00');
                 $current_credit = Auth::user()->current_credit;
                 $last_credit = Auth::user()->last_statement_credit;
                 $user->current_credit = $last_credit;
                 $user->last_statement_credit = $current_credit;
                 $user->save();
             }
             else{
                $user->paid_check = 1;
                $user->save();
             }
         }
    }
}
