<?php

namespace GoWeb\Api\Model\Client;

class ClientBaseService extends AbstractClientService
{    
    private $_additionalServices = null;
    
    private $_linkedDevice;
    
    const STATUS_ACTIVE     = 'ACTIVE';
    const STATUS_SUSPENDED  = 'SUSPENDED';
    const STATUS_BLOCKED    = 'BLOCKED';
    const STATUS_CLOSED     = 'CLOSED';
    
    public function getName()
    {
        return $this->get('name');
    }
    
    public function setName($name)
    {
        $this->set('name', $name);
        return $this; 
    }
    
    public function getBaseServiceId()
    {
        return (int) $this->get('service_id');
    }
    
    public function setBaseServiceId($baseServiceId)
    {
        $this->set('service_id', (int) $baseServiceId);
        return $this; 
    }
    
    public function getChangedBaseServiceId()
    {
        return (int) $this->get('service_id_change');
    }
    
    public function setChangedBaseServiceId($baseServiceId)
    {
        $this->set('service_id_change', (int) $baseServiceId);
        return $this; 
    }
    
    public function isBaseServiceChanged($baseServiceId)
    {
        return (bool) $this->get('service_id_change');
    }
    
    public function isActive()
    {
        return self::STATUS_ACTIVE == $this->getStatus();
    }
    
    public function setStatus($status) {
        $this->set('status', $status);
        return $this;
    }
    
    public function getStatus()
    {
        return $this->get('status');
    }
    
    public function setChangedStatus($status) {
        $this->set('status_change', $status);
        return $this;
    }
    
    public function getChangedStatus()
    {
        return $this->get('status_change');
    }
    
    public function isStatusChanged()
    {
        return (bool) $this->get('status_change');
    }
    
    public function isCatchUpAllowed()
    {
        return (bool) $this->get('catchup');
    }
    
    public function setCatchUpAllowed($allowed = true) {
        $this->set('catchup', (int) $allowed);
        return $this;
    }
    
    public function isAdAllowed()
    {
        return (bool) $this->get('ad');
    }
    
    public function setAdAllowed($allowed = true) {
        $this->set('ad', (int) $allowed);
        return $this;
    }
    
    
    
    public function setCost($cost) {
        parent::setCost($cost);
        
        $this->remove('total_cost', null);
        $this->remove('total_monthly_cost', null);
        
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
        return $this->get('chargeoff_period');
    }
    
    public function getMonthlyCost()
    {
        if(null === $this->getCost()) {
            return null;
        }
        
        switch($this->get('chargeoff_period'))
        {
            case self::CHARGEOF_PERIOD_DAILY:
                return $this->getCost() * self::DAYS_IN_MONTH;
            
            case self::CHARGEOF_PERIOD_MONTHLY:
                return $this->getCost();
        }
    }
    
    public function hasLinkedDevice()
    {
        return (bool) $this->get('stb');
    }
    
    /**
     * 
     * @return GoWeb\Api\Device
     * @throws \Exception
     */
    public function getLinkedDevice()
    {
        if($this->_linkedDevice) {
            return $this->_linkedDevice;
        }
        
        if(!$this->hasLinkedDevice()) {
            throw new \Exception('Device not linked');
        }
        
        $this->_linkedDevice = new Device($this->get('stb'));
        
        return $this->_linkedDevice;
    }
    
    public function setLinkedDevice(Device $device) {
        $this->_linkedDevice = $device;
        return $this;
    }
    
    public function getAdditionalServices()
    {
        if(null !== $this->_additionalServices) {
            return $this->_additionalServices;
        }
        
        $additionalServices = $this->get('additional');
        
        if($additionalServices) {
            $this->_additionalServices = array_map(function($additionalServiceSection) {
                return new ClientAdditionalService($additionalServiceSection);
            }, $additionalServices);
        }
        else {
            $this->_additionalServices = array();
        }
        
        return $this->_additionalServices;
    }
    
    public function addAdditionalService(ClientAdditionalService $service) {
        if(!$this->_additionalServices) {
            $this->_additionalServices = array();
        }
        
        $this->_additionalServices[] = $service;
        $this->remove('total_cost', null);
        $this->remove('total_monthly_cost', null);
        
        return $this;
    }
    
    
    public function hasAdditionalServices()
    {
        return (bool) $this->get('additional');
    }
    
    /**
     * @param type $clientAdditionalServiceId
     * @return boolean
     */
    public function hasAdditionalService($clientAdditionalServiceId)
    {
        if(!$this->hasAdditionalServices()) {
            return false;
        }
        
        foreach($this->getAdditionalServices() as $clientAdditionalService) {
            if($clientAdditionalService->getId() === (int) $clientAdditionalServiceId) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get list of base and all additional services
     * 
     * @return array
     */
    public function getServiceIdList() {
        $list = array();
        
        $list[] = $this->getBaseServiceId();
        
        $additionalServices = $this->get('additional');
        
        if($additionalServices) {
            foreach($additionalServices as $additionalService) {
                $list[] = $additionalService['service_id'];
            }
        }
        
        return $list;
    }
    
    private function recalcTotalCost()
    {
        $totalCost = $this->getCost();
        if(null === $totalCost) {
            return $this;
        }
        
        // day
        foreach($this->getAdditionalServices() as $additionalService) {
            /* @var $additionalService \GoWeb\Api\Model\Client\ClientAdditionalService */
            $totalCost += $additionalService->getCost();
        }

        $this->set('total_cost', $totalCost);            
        
        // month
        $chargeOffperiod = $this->getChargeOffPeriod();
        if($chargeOffperiod && $chargeOffperiod !== self::CHARGEOF_PERIOD_MONTHLY) {
            $totalMonthlyCost = $this->getMonthlyCost();
            
            foreach($this->getAdditionalServices() as $additionalService) {
                /* @var $additionalService \GoWeb\Api\Model\Client\ClientAdditionalService */
                $totalMonthlyCost += $additionalService->getMonthlyCost();
            }
        
            $this->set('total_monthly_cost', $totalMonthlyCost);
        }
        
        // define
        return $this;
    }
    
    public function getTotalCost() {
        if(!$this->get('total_cost')) {
            $this->recalcTotalCost();
        }
        
        return $this->get('total_cost');
    }
    
    public function getTotalMonthCost()
    {
        if(!$this->get('total_monthly_cost')) {
            $this->recalcTotalCost();
        }
        
        return $this->get('total_monthly_cost');
    }
    
    public function toArray() {
        if(!$this->get('total_cost') || !$this->get('total_monthly_cost')) {
            $this->recalcTotalCost();
        }
        
        if($this->_additionalServices) {
            $this->set('additional', array_map(function($service) { return $service->toArray(); }, $this->_additionalServices));
        }
        
        if($this->_linkedDevice) {
            $this->set('stb', $this->_linkedDevice->toArray());
        }
        
        return parent::toArray();
    }
}