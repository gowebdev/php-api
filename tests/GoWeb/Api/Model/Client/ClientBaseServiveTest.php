<?php

namespace GoWeb\Api\Model\Client;

class ClientBaseServiceTest extends \PHPUnit_Framework_TestCase
{ 
    public function testSetLinkedDevice()
    {
        // init objects
        $clientBaseService = new ClientBaseService;
        $device = new Device;
        
        // add device to service
        $clientBaseService->setLinkedDevice($device);
        
        //device params
        $device
            ->setId(123)
            ->setMac('12:34:56:78:90:AB')
            ->setSerial('AB1234567');
        
        $this->assertEquals(array(
            'stb'   => array(
                'id'        => 123,
                'mac'       => '12:34:56:78:90:AB',
                'serial'    => 'AB1234567',
            )
        ), $clientBaseService->toArray());
    }
    
    public function testTotalCost()
    {
        $clientBaseService = new ClientBaseService;
        
        // no cost defined
        $this->assertEquals([], $clientBaseService->toArray());
        
        // define base cost
        $clientBaseService->setCost(12.2);
        $this->assertEquals([
            'cost'          => 12.2,
            'total_cost'    => 12.2
        ], $clientBaseService->toArray());
        
        // define additional cost
        $additionalService = new ClientAdditionalService;
        $additionalService->setCost(15.3);
        
        $clientBaseService->addAdditionalService($additionalService);
        $this->assertEquals([
            'cost'          => 12.2,
            'total_cost'    => 27.5,
            'additional'    => [
                ['cost'  => 15.3],
            ],
        ], $clientBaseService->toArray());
    }
    
    public function testTotalMonthlyCost()
    {
        $clientBaseService = new ClientBaseService;
        
        // no cost defined
        $this->assertEquals([], $clientBaseService->toArray());
        
        // define base cost
        $clientBaseService
            ->setCost(1.01)
            ->setChargeOffPeriod(ClientBaseService::CHARGEOF_PERIOD_DAILY);
        
        $this->assertEquals([
            'cost'                  => 1.01,
            'chargeoff_period'      => ClientBaseService::CHARGEOF_PERIOD_DAILY,
            'total_cost'            => 1.01,
            'total_monthly_cost'    => 30.3,
        ], $clientBaseService->toArray());
        
        // define additional cost
        $additionalService = new ClientAdditionalService;
        $additionalService
            ->setCost(2.02)
            ->setChargeOffPeriod(ClientBaseService::CHARGEOF_PERIOD_DAILY);
        
        $clientBaseService->addAdditionalService($additionalService);
        $this->assertEquals([
            'cost'                  => 1.01,
            'chargeoff_period'      => ClientBaseService::CHARGEOF_PERIOD_DAILY,
            'total_cost'            => 3.03,
            'total_monthly_cost'    => 90.9,
            'additional'    => [
                [
                    'cost'              => 2.02,
                    'chargeoff_period'  => ClientBaseService::CHARGEOF_PERIOD_DAILY,
                ],
            ],
        ], $clientBaseService->toArray());
    }
    
    /**
     * @covers GoWeb\Api\Model\Client\ClientBaseServiceTest::hasAdditionalService()
     */
    public function testHasAdditionalService()
    {
        $clientBaseService = new ClientBaseService(array(
            "id" => 45599,
            "service_id" => 9,
            "name" => "Домашний",
            "custom_name" => "Послуга№45599",
            "cost" => 0.033,
            "chargeoff_period" => "DAILY",
            "status" => "ACTIVE",
            "catchup" => 1,
            "ad" => 0,
            "total_cost" => 1.033,
            "total_monthly_cost" => 30.99,
            "additional" => array(
                array(
                    "id" => 45602,
                    "service_id" => 30,
                    "name" => "Additional1",
                    "cost" => 1,
                    "chargeoff_period" => "DAILY"
                )
            )
        ));
        
        $this->assertTrue($clientBaseService->hasAdditionalService(45602));
        $this->assertTrue($clientBaseService->hasAdditionalService("45602"));
        $this->assertFalse($clientBaseService->hasAdditionalService(123456));
    }
}