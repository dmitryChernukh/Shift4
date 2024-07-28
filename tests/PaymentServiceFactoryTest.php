<?php

namespace App\Tests;

use App\Factory\PaymentServiceFactory;
use App\Service\AciService;
use App\Service\Shift4Service;
use PHPUnit\Framework\TestCase;

class PaymentServiceFactoryTest extends TestCase
{
    public function testGetService()
    {
        $shift4Service = $this->createMock(Shift4Service::class);
        $aciService = $this->createMock(AciService::class);

        $factory = new PaymentServiceFactory($shift4Service, $aciService);

        $this->assertInstanceOf(Shift4Service::class, $factory->getService('shift4'));
        $this->assertInstanceOf(AciService::class, $factory->getService('aci'));
    }

    public function testGetServiceInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);

        $shift4Service = $this->createMock(Shift4Service::class);
        $aciService = $this->createMock(AciService::class);

        $factory = new PaymentServiceFactory($shift4Service, $aciService);
        $factory->getService('invalid');
    }
}
