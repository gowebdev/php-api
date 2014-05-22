<?php

namespace GoWeb\Api\Model\Client;

class ClientAdditionalService extends \Sokil\Rest\Transport\Structure
{
   
    public function getId()
    {
        return (int) $this->get('id');
    }
    
    public function setId($id)
    {
        $this->set('id', (int) $id);
        return $this;
    }
    
    public function getClientId()
    {
        return (int) $this->get('client_id');
    }
    
    public function setClientId($id)
    {
        $this->set('client_id', (int) $id);
        return $this;
    }
    
    public function getCustomName()
    {
        return $this->get('name');
    }
    
    public function setCustomName($name  = null)
    {
        if($name) {
            $this->set('name', $name);
        } else {
            $this->remove('name');
        }
        
        return $this;
    }
    
    public function getAdditionalServiceId()
    {
        return $this->get('service_id');
    }
    
    public function setAdditionalServiceId($id)
    {
        $this->get('service_id', (int) $id);
        return $this; 
    }
    
    public function getCost()
    {
        return $this->get('cost');
    }
    
    public function setCost($cost)
    {
        $this->set('cost', (float) $cost);
        return $this;
    }
}