<?php

namespace GoWeb\Api\Model\Client;

class Device extends \Sokil\Rest\Transport\Structure
{    
    public function getId()
    {
        return $this->get('id');
    }
    
    public function setId($id)
    {
        $this->set('id', (int) $id);
        return $this; 
    }
    
    public function getSerial()
    {
        return $this->get('serial');
    }
    
    public function setSerial($serial)
    {
        $this->set('serial', $serial);
        return $this; 
    }
    
    public function getMac()
    {
        return $this->get('mac');
    }
    
    public function setMac($mac)
    {
        $this->set('mac', $mac);
        return $this;
    }
}