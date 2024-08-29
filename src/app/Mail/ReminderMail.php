<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $qrcode_url = route('qrcode', ['id' => $this->reservation->id]);
        $payment_url = route('payment.index', ['id' => $this->reservation->id]);

        return  $this->subject('本日のご予約確認')
            ->view('emails.reminder')
            ->with(['reservation' => $this->reservation,
                    'qrcode_url' => $qrcode_url,
                    'payment_url' => $payment_url]);
    }
}
