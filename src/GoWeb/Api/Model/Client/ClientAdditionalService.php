<?php

namespace GoWeb\Api\Model\Client;

class ClientAdditionalService
{
    private $_serviceSection = array();
    
    public function __construct(array $serviceSection = null)
    {
        if($serviceSection) {
            $this->_serviceSection = $serviceSection;
        }
    }
    
    public function getId()
    {
        return (int) $this->_serviceSection['id'];
    }
    
    public function setId($id)
    {
        if(!$this->_serviceSection['client_id']) {
            throw new \Exception('Can\'t set id of new cleint\'s service');
        }
        
        $this->_serviceSection['id'] = (int) $id;
        return $this;
    }
    
    public function getClientId()
    {
        return (int) $this->_serviceSection['client_id'];
    }
    
    public function setClientId($id)
    {
        if(!$this->_serviceSection['id']) {
            throw new \Exception('Client of existed service can\'t be modified');
        }
        
        $this->_serviceSection['client_id'] = (int) $id;
        return $this;
    }
    
    public function getCustomName()
    {
        return $this->_serviceSection['name'];
    }
    
    public function setCustomName($name)
    {
        $this->_serviceSection['name'] = $name;
        return $this;
    }
    
    public function getAdditionalServiceId()
    {
        return $this->_serviceSection['service_id'];
    }
    
    public function setAdditionalServiceId($id)
    {
        $this->_serviceSection['service_id'] = (int) $id;
        return $this; 
    }
    
    public function getCost()
    {
        return isset($this->_serviceSection['cost']) ? (float) $this->_serviceSection['cost'] : null;
    }
    
    public function setCost($cost)
    {
        $this->_serviceSection['cost'] = (float) $cost;
        return $this;
    }
    
    public function toArray() {
        return $this->_serviceSection;
    }
}