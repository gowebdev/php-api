<?php

namespace GoWeb\Api\Model\Client;

class AbstractClientServiceTest extends \PHPUnit_Framework_TestCase
{ 
    public function testSetRegionsAsString()
    {
        $clientBaseService = new ClientBaseService();
        $clientBaseService->setRegions('uk,ru,en');
        
        $this->assertEquals(array('uk','ru','en'), $clientBaseService->getRegions());
    }
    
    public function testSetRegionsAsArray()
    {
        $clientBaseService = new ClientBaseService();
        $clientBaseService->setRegions(array('uk','ru','en'));
        
        $this->assertEquals(array('uk','ru','en'), $clientBaseService->getRegions());
    }
    
    public function testGetRegions()
    {
        $clientBaseService = new ClientBaseService(array(
            
        ));
        
        $this->assertEquals(null, $clientBaseService->getRegions());
    }
}