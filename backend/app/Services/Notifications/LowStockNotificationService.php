<?php

namespace App\Services\Notifications;

use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Mail\LowStockNotificationMail;
use Illuminate\Support\Facades\Mail;

class LowStockNotificationService implements LowStockNotificationServiceInterface
{
    protected UserRepository $userRepository;
    protected ProductRepository $productRepository;

    public function __construct(
        UserRepository $userRepository,
        ProductRepository $productRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function handle(int $productId): void
    {
        //product
        $product = $this->productRepository->getById($productId);

        //admin emails
        $emails = [];
        $admins = $this->userRepository->getAdmins();
        foreach ($admins as $admin) {
            $emails[] = $admin->email;
        }

        //send email
        if (!empty($emails)) {
            Mail::to($emails)->send(new LowStockNotificationMail($product));
        }
    }
}
