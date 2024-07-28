<?php

namespace App\Service;

interface PaymentServiceInterface
{
    public function makePurchase(array $params): array;
}
