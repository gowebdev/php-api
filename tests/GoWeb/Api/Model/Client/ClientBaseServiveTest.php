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
        $this->assertEquals(['total_cost' => 0], $clientBaseService->toArray());
        
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
}