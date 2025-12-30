<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailySalesReportMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public array $data
    ) {}

    public function build()
    {
        return $this
            ->subject('Daily Sales Report')
            ->view('emails.daily-sales-report');
    }
}
