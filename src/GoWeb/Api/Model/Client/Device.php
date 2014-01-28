<?php

namespace GoWeb\Api\Model\Client;

class Device
{
    private $_data = array();
    
    public function __construct(array $deviceSection = null)
    {
        if($deviceSection) {
            $this->_data = $deviceSection;
        }
    }
    
    public function getId()
    {
        return $this->_data['id'];
    }
    
    public function setId($id)
    {
        $this->_data['id'] = (int) $id;
        return $this; 
    }
    
    public function getSerial()
    {
        return $this->_data['serial'];
    }
    
    public function setSerial($serial)
    {
        $this->_data['serial'] = $serial;
        return $this; 
    }
    
    public function getMac()
    {
        return $this->_data['mac'];
    }
    
    public function setMac($mac)
    {
        $this->_data['mac'] = $mac;
        return $this;
    }
    
    public function toArray() {
        return $this->_data;
    }
}