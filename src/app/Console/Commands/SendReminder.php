<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Models\User;
use App\Models\Reservation;
use App\Mail\ReminderMail;
use Carbon\Carbon;

class SendReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder mail';

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
        $today = Carbon::today()->format('Y-m-d');
        $reservations = Reservation::whereDate('date', $today)->get();
        if($reservations) {
            foreach($reservations as $reservation) {
                Mail::to($reservation->user)->send(new ReminderMail($reservation));
            }
        }
    }
}
