<?php

namespace GoWeb\Api\Model\Client;

class ClientBaseService extends \Sokil\Rest\Transport\Structure
{    
    private $_additionalServices = array();
    
    private $_linkedDevice;
    
    const STATUS_ACTIVE     = 'ACTIVE';
    const STATUS_SUSPENDED  = 'SUSPENDED';
    const STATUS_BLOCKED    = 'BLOCKED';
    const STATUS_CLOSED     = 'CLOSED';
    
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
    
    public function getName()
    {
        return $this->get('name');
    }
    
    public function setName($name)
    {
        $this->set('name', $name);
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
    
    public function getCost()
    {
        return (float) $this->get('cost');
    }
    
    public function setCost($cost) {
        $this->set('cost', (float) $cost);
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
        else
        {
            $this->_additionalServices = array();
        }
        
        return $this->_additionalServices;
    }
    
    public function addAdditionalService(ClientAdditionalService $service) {
        $this->_additionalServices[] = $service;
        $this->remove('total_cost', null);
        $this->remove('total_monthly_cost', null);
        
        return $this;
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