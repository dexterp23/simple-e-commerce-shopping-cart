<?php

namespace App\Services\Notifications;

use App\Mail\DailySalesReportMail;
use App\Repositories\CartRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;

class DailySalesReportService
{
    protected UserRepository $userRepository;
    protected CartRepository $cartRepository;

    public function __construct(
        UserRepository $userRepository,
        CartRepository $cartRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
    }

    public function handle(): void
    {
        //products
        $products = [];
        $carts = $this->cartRepository->getCreatedToday();
        foreach ($carts as $cart) {
            foreach ($cart->products as $product) {
                if (empty($products[$product->product_id])) {
                    $products[$product->product_id] = [
                        'name' => $product->product->name,
                        'quantity' => $product->quantity,
                    ];
                } else {
                    $products[$product->product_id]['quantity'] += $product->quantity;
                }
            }
        }

        //admin emails
        $emails = [];
        $admins = $this->userRepository->getAdmins();
        foreach ($admins as $admin) {
            $emails[] = $admin->email;
        }

        //send email
        if (!empty($products) && !empty($emails)) {
            Mail::to($emails)->send(new DailySalesReportMail($products));
        }
    }
}
