<?php

namespace GoWeb\Api\Model\Client;

class ClientBaseService
{
    private $_serviceSection = array();
    
    private $_additionalServices = array();
    
    private $_linkedDevice;
    
    const STATUS_ACTIVE     = 'ACTIVE';
    const STATUS_SUSPENDED  = 'SUSPENDED';
    const STATUS_BLOCKED    = 'BLOCKED';
    const STATUS_CLOSED     = 'CLOSED';
    
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
        $this->_serviceSection['id'] = (int) $id;
        return $this;
    }
    
    public function getClientId()
    {
        return (int) $this->_serviceSection['client_id'];
    }
    
    public function setClientId($id)
    {        
        $this->_serviceSection['client_id'] = (int) $id;
        return $this;
    }
    
    public function getName()
    {
        return $this->_serviceSection['name'];
    }
    
    public function setName($name)
    {
        $this->_serviceSection['name'] = $name;
        return $this; 
    }
    
    public function getCustomName()
    {
        return $this->_serviceSection['custom_name'];
    }
    
    public function setCustomName($customName)
    {
        $this->_serviceSection['custom_name'] = $customName;
        return $this; 
    }
    
    public function getBaseServiceId()
    {
        return (int) $this->_serviceSection['service_id'];
    }
    
    public function setBaseServiceId($baseServiceId)
    {
        $this->_serviceSection['service_id'] = (int) $baseServiceId;
        return $this; 
    }
    
    public function getChangedBaseServiceId()
    {
        return (int) $this->_serviceSection['service_id_change'];
    }
    
    public function setChangedBaseServiceId($baseServiceId)
    {
        $this->_serviceSection['service_id_change'] = (int) $baseServiceId;
        return $this; 
    }
    
    public function isBaseServiceChanged($baseServiceId)
    {
        return !empty($this->_serviceSection['service_id_change']);
    }
    
    public function isActive()
    {
        return self::STATUS_ACTIVE == $this->_serviceSection['status'];
    }
    
    public function setStatus($status) {
        $this->_serviceSection['status'] = $status;
        return $this;
    }
    
    public function getStatus()
    {
        return $this->_serviceSection['status'];
    }
    
    public function setChangedStatus($status) {
        $this->_serviceSection['status_change'] = $status;
        return $this;
    }
    
    public function getChangedStatus()
    {
        return $this->_serviceSection['status_change'];
    }
    
    public function isStatusChanged()
    {
        return !empty($this->_serviceSection['status_change']);
    }
    
    public function isCatchUpAllowed()
    {
        return !empty($this->_serviceSection['catchup']);
    }
    
    public function setCatchUpAllowed($allowed = true) {
        $this->_serviceSection['catchup'] = (int) $allowed;
        return $this;
    }
    
    public function isAdAllowed()
    {
        return !empty($this->_serviceSection['ad']);
    }
    
    public function setAdAllowed($allowed = true) {
        $this->_serviceSection['ad'] = (int) $allowed;
        return $this;
    }
    
    public function getCost()
    {
        return isset($this->_serviceSection['cost']) ? (float) $this->_serviceSection['cost'] : null;
    }
    
    public function setCost($cost) {
        $this->_serviceSection['cost'] = (float) $cost;
        $this->_serviceSection['total_cost'] = null;
        return $this;
    }
    
    public function hasLinkedDevice()
    {
        return !empty($this->_serviceSection['stb']);
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
        
        $this->_linkedDevice = new Device($this->_serviceSection['stb']);
        
        return $this->_linkedDevice;
    }
    
    public function setLinkedDevice(Device $device) {
        $this->_linkedDevice = $device;
        $this->_serviceSection['stb'] = $device->toArray();
        return $this;
    }
    
    public function getAdditionalServices()
    {
        if(null !== $this->_additionalServices) {
            return $this->_additionalServices;
        }
        
        if(!empty($this->_serviceSection['additional'])) {
            $this->_additionalServices = array_map(function($additionalServiceSection) {
                return new ClientAdditionalService($additionalServiceSection);
            }, $this->_serviceSection['additional']);
        }
        else
        {
            $this->_additionalServices = array();
        }
        
        return $this->_additionalServices;
    }
    
    public function addAdditionalService(ClientAdditionalService $service) {
        $this->_additionalServices[] = $service;
        $this->_serviceSection['total_cost'] = null;
        
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
        
        if(!empty($this->_serviceSection['additional'])) {
            foreach($this->_serviceSection['additional'] as $additionalService) {
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
        
        $this->_serviceSection['total_cost'] = $this->getCost();
        
        foreach($this->getAdditionalServices() as $additionalService) {
            $this->_serviceSection['total_cost'] += $additionalService->getCost();
        }
        
        return $this;
    }
    
    public function getTotalCost() {
        if(empty($this->_serviceSection['total_cost'])) {
            $this->recalcTotalCost();
        }
        return $this->_serviceSection['total_cost'];
    }
    
    public function toArray() {
        if(empty($this->_serviceSection['total_cost'])) {
            $this->recalcTotalCost();
        }
        
        if($this->_additionalServices) {
            $this->_serviceSection['additional'] = array_map(function($service) { return $service->toArray(); }, $this->_additionalServices);
        }
        
        return $this->_serviceSection;
    }
}