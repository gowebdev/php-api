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
}