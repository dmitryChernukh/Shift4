<?php

namespace App\Factory;

use App\Service\AciService;
use App\Service\PaymentServiceInterface;
use App\Service\Shift4Service;

class PaymentServiceFactory
{
    private Shift4Service $shift4Service;
    private AciService $aciService;

    public function __construct(Shift4Service $shift4Service, AciService $aciService)
    {
        $this->shift4Service = $shift4Service;
        $this->aciService = $aciService;
    }

    final public function getService(string $system): PaymentServiceInterface
    {
        return match ($system) {
            'shift4' => $this->shift4Service,
            'aci' => $this->aciService,
            default => throw new \InvalidArgumentException('Invalid system'),
        };
    }
}
