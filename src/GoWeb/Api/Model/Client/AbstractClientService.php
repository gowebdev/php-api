<?php

namespace GoWeb\Api\Model\Client;

abstract class AbstractClientService extends \Sokil\Rest\Transport\Structure
{
    const CHARGEOF_PERIOD_DAILY     = 'DAILY';
    const CHARGEOF_PERIOD_MONTHLY   = 'MONTHLY';
    
    const DAYS_IN_MONTH = 30;
    
    public function getType()
    {
        return $this->get('type');
    }
    
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
        return $this->get('custom_name');
    }
    
    public function setCustomName($name  = null)
    {
        if($name) {
            $this->set('custom_name', $name);
        } else {
            $this->remove('custom_name');
        }
        
        return $this;
    }
    
    public function getCost()
    {
        return $this->get('cost') === null ? null : (float) $this->get('cost');
    }
    
    public function setCost($cost)
    {
        $this->set('cost', (float) $cost);
        return $this;
    }
    
    public function setRegions($regions)
    {
        if(is_array($regions)) {
            $regions = implode(',', $regions);
        }
        
        $this->set('regions', $regions);
        return $this;
    }
    
    public function getRegions()
    {
        $regions = $this->get('regions');
        if(!is_array($regions)) {
            $regions = explode(',', $regions);
        }
        
        return $regions;
    }
}