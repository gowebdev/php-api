<?php

namespace GoWeb\Api\Model\Client;

class ClientAdditionalService extends \Sokil\Rest\Transport\Structure
{
    const CHARGEOF_PERIOD_DAILY     = 'DAILY';
    const CHARGEOF_PERIOD_MONTHLY   = 'MONTHLY';
    
    const DAYS_IN_MONTH = 30;
   
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
        $this->set('service_id', (int) $id);
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
    
    public function setChargeoffPeriod($period)
    {
        if(!in_array($period, [self::CHARGEOF_PERIOD_DAILY, self::CHARGEOF_PERIOD_MONTHLY])) {
            throw new \Exception('Wrong changeoff period specified');
        }
        
        $this->set('chargeoff_period', $period);
        return $this;
    }
    
    public function getChargeOffPeriod()
    {
        return $this->set('chargeoff_period');
    }
    
    public function getMonthlyCost()
    {
        switch($this->get('chargeoff_period'))
        {
            case self::CHARGEOF_PERIOD_DAILY:
                return $this->getCost() * self::DAYS_IN_MONTH;
            
            case self::CHARGEOF_PERIOD_MONTHLY:
                return $this->getCost();
        }
    }
    
    public function getClientBaseServiceId()
    {
        return $this->get('client_base_service_id');
    }
    
    public function setClientBaseServiceId($id)
    {
        $this->set('client_base_service_id', (int) $id);
        return $this; 
    }
}