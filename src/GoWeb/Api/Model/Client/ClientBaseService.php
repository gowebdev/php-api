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
        return $this->get('cost');
    }
    
    public function setCost($cost) {
        $this->set('cost', (float) $cost);
        $this->set('total_cost', null);
        return $this;
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
        $this->set('stb', $device->toArray());
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
        $this->set('total_cost', null);
        
        return $this;
    }
    
    public function hasAdditionalService($clientAdditionalServiceId)
    {
        $has = false;
        foreach($this->getAdditionalServices() as $additionalService)
        {
            /* @var $additionalService \GoWeb\Api\Model\Client\ClientAdditionalService */
            if($additionalService->getId() === (int) $clientAdditionalServiceId) {
                $has = true;
                break;
            }
        }
        
        return $has;
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
        $baseCost = $this->getCost();
        if(!$baseCost) {
            return $this;
        }
        
        $totalCost = $this->getCost();
        
        foreach($this->getAdditionalServices() as $additionalService) {
            $totalCost += $additionalService->getCost();
        }
        
        $this->set('total_cost', $totalCost);
        
        return $this;
    }
    
    public function getTotalCost() {
        if(!$this->get('total_cost')) {
            $this->recalcTotalCost();
        }
        return $this->get('total_cost');
    }
    
    public function toArray() {
        if(!$this->get('total_cost')) {
            $this->recalcTotalCost();
        }
        
        if($this->_additionalServices) {
            $this->set('additional', array_map(function($service) { return $service->toArray(); }, $this->_additionalServices));
        }
        
        return parent::toArray();
    }
}