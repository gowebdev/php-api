<?php

namespace GoWeb\Api\Model;

use \GoWeb\Api\Model\Client\ClientBaseService as RemoteProfileClientBaseService;

class Client extends \GoWeb\Api\Model
{    
    const STATUS_ACTIVE     = 'ACTIVE';
    const STATUS_BLOCKED    = 'BLOCKED';
    const STATUS_SUSPENDED  = 'SUSPENDED';
    const STATUS_CLOSED     = 'CLOSED';
    
    /**
     *
     * @var \GoWeb\Api\Model\Client\Profile
     */
    private $_profile;
    
    /**
     *
     * @var array
     */
    private $_baseServices = array();
    
    public function __clone() {
        if($this->_profile) {
            $this->_profile = clone $this->_profile;
        }
    }
    
    public function getToken()
    {
        return $this->getParam('token');
    }

    public function setToken( $token )
    {
        $this->setParam('token', $token);
    }
    
    /**
     * 
     * @param type $key
     * @return \GoWeb\Api\Model\Client\Profile
     * @throws \Exception
     */
    public function getProfile()
    {
        if(!$this->_profile) {
            $this->_profile = new Client\Profile($this->_data['profile']);
        }
        
        return $this->_profile;
    }
    
    public function getId()
    {
        return $this->getProfile()->getId();
    }
    
    public function getPermanentId()
    {
         return $this->getParam('permid');
    }
    
    public function getHash()
    {
        return $this->getProfile()->getHash();
    }
    
    public function getEmail()
    {
        return $this->getProfile()->getEmail();
    }

    public function getLastName()
    {
        return $this->getProfile()->getLastName();
    }

    public function getFirstName()
    {
        return $this->getProfile()->getFirstName();
    }

    public function getFullName()
    {
        $fullName = implode(' ', array
        (
            $this->getLastName(),
            $this->getFirstName()
        ));

        return $fullName == ' ' ? null : $fullName;
    }
    
    public function getContractNumber()
    {
        return $this->getProfile()->getContractNumber();
    }
    
    public function isActive()
    {
        return self::STATUS_ACTIVE == $this->getStatus();
    }
    
    public function getStatus()
    {
        return $this->getProfile()->getStatus();
    }
    
    public function getGender()
    {
        return $this->getProfile()->getGender();
    }

    public function getBirthday($format = null)
    {
        $birthday = $this->getProfile()->getBirthday();
        if(!$birthday)
            return null;

        if(!$format)
            return $birthday;

        if(!is_numeric($birthday)) {
            $birthday = strtotime($birthday);
        }

        return date($format, $birthday);
    }
    
    public function setBalance($ammount, $currency) {
        $this->_data['balance'] = array(
            'amount'    => $ammount,
            'currency'  => $currency,
        );
        
        return $this;
    }
    
    public function getBalance($key = null)
    {
        if(!$this->_data['balance'])
            throw new \Exception('Balance section not specified');
        
        if(!$key)
            return $this->_data['balance'];
        
        return isset($this->_data['balance'][$key]) ? $this->_data['balance'][$key] : null;
    }
    
    public function getBalanceAmount()
    {
        return (float) $this->getBalance('amount');
    }
    
    public function getBalanceCurrency()
    {
        return $this->getBalance('currency');
    }
    
    public function hasServices()
    {
        return !empty($this->_data['baseServices']);
    }
    
    public function getClientBaseServicesAsArray()
    {
        if(empty($this->_data['baseServices'])) {
            $this->_data['baseServices'] = array();
        }
        
        return $this->_data['baseServices'];
    }

    /**
     * 
     * @return array client base services with included additional client services and STBs
     */
    public function getClientBaseServices() {
        if($this->_baseServices) {
            return $this->_baseServices;
        }
        
        foreach($this->getClientBaseServicesAsArray() as $baseServiceSection) {
            $this->_baseServices[] = new RemoteProfileClientBaseService($baseServiceSection);
        }
        
        return $this->_baseServices;
    }
    
    public function addClientBaseService(RemoteProfileClientBaseService $service) {
        
        $this->_baseServices[] = $service;

        return $this;
    }
    
    public function getActiveServiceIdList()
    {
        // base service
        $services = array($this->getActiveClientBaseService()->getBaseServiceId());  
        
        // additional services servive ids
        foreach($this->getActiveClientBaseService()->getAdditionalServices() as $additionalService)
        {
            $services[] = $additionalService->getAdditionalServiceId();
        }
        
        return array_unique($services);
    }
    
    public function setActiveClientBaseServiceId($id)
    {        
        $id = (int) $id;
        if(!$id)
            throw new \Exception('Wrong active client service id specified');

        foreach($this->getClientBaseServices() as $baseService)
        {
            if($baseService->getId() != $id)
                continue;
            
            $this->_data['activeBaseService'] = $id;
            return;
        }
        
        throw new \Exception('Wrong client base service specified');
    }
    
    public function getActiveClientBaseServiceId()
    {
        if(!isset($this->_data['activeBaseService']))
        {
            $baseClientServices = $this->getClientBaseServices();
            if(!$baseClientServices) {
                return null;
            }

            // init loop
            $mostExpensiveBaseService = current($baseClientServices);
            
            // search most expensive
            while(false !== ($baseService = next($baseClientServices)))
            {                
                if($baseService->getCost() <= $mostExpensiveBaseService->getCost()) {
                    $mostExpensiveBaseService = $baseService;
                }
            }
            
            $this->_data['activeBaseService'] = $mostExpensiveBaseService->getId();
        }
        
        return $this->_data['activeBaseService'];
    }
    
    /**
     * Demo Client instance
     * @return type
     */
    public function isDemo() {
        return !$this->getActiveClientBaseServiceId();
    }
    
    public function enableTester()
    {
        $this->getProfile()->enableTester();
        return $this;
    }
    
    public function disableTester()
    {
        $this->getProfile()->disableTester();
        return $this;
    }
    
    public function isTester()
    {
        return $this->getProfile()->isTester();
    }
    
    /**
     * 
     * @return \GoWeb\Api\Model\Client\ClientBaseService
     */
    public function getActiveClientBaseService()
    {
        $baseServices = $this->getClientBaseServices();
        
        foreach($baseServices as $baseService) {
            if($baseService->getId()  === $this->getActiveClientBaseServiceId()) {
                return $baseService;
            }
        }
        
        throw new \Exception('Base service with specified id not found');
    }
    
    public function getRechargePageUrl()
    {
        return isset($this->_data['rechargePage']) ? $this->_data['rechargePage'] : null;
    }
    
    public function getpfofilePageUrl()
    {
        return isset($this->_data['profilePage']) ? $this->_data['profilePage'] : null;
    }
    
    public function toArray() {
        
        if($this->_profile) {
            $this->_data['profile'] = $this->_profile->toArray();
        }
        
        if($this->_baseServices) {
            $this->_data['baseServices'] = array_map(function($service) { return $service->toArray(); }, $this->_baseServices);
        }

        return $this->_data;
    }
    
    public function toJson() {
        return json_encode($this->toArray());
    }
}