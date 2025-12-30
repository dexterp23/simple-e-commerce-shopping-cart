<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowStockNotificationMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public Product $data
    ) {}

    public function build()
    {
        return $this
            ->subject('Low Stock Notification')
            ->view('emails.low-stock-notification');
    }
}
