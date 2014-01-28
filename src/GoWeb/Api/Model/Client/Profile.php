<?php

namespace GoWeb\Api\Model\Client;

class Profile
{
    private $_data = array();
    
    public function __construct(array $data = null) {
        
        if($data) {
            $this->_data = $data;
        }
    }
    
    public function setId($id) {
        $this->_data['id'] = (int) $id;
        
        return $this;
    }
    
    public function getId() {
        return isset($this->_data['id']) ? (int) $this->_data['id'] : null;
    }
    
    public function setEmail($email) {
        $this->_data['email'] = $email;
        
        return $this;
    }
    
    public function getEmail() {
        return isset($this->_data['email']) ? $this->_data['email'] : null;
    }
    
    public function setPassword($password) {
        $this->_data['password'] = $password;
        
        return $this;
    }
    
    public function getPassword() {
        return isset($this->_data['password']) ? $this->_data['password'] : null;
    }
    
    public function setHash($hash) {
        $this->_data['hash'] = $hash;
        
        return $this;
    }
    
    public function getHash() {
        return isset($this->_data['hash']) ? $this->_data['hash'] : null;
    }
    
    public function setLastName($lastName) {
        $this->_data['last_name'] = $lastName;
        
        return $this;
    }
    
    public function getLastName() {
        return $this->_data['last_name'];
    }
    
    public function setFirstName($firstName) {
        $this->_data['first_name'] = $firstName;
        
        return $this;
    }
    
    public function getFirstName() {
        return $this->_data['first_name'];
    }
    
    public function setGender($gender) {
        $this->_data['gender'] = $gender;
        
        return $this;
    }
    
    public function getGender() {
        return $this->_data['gender'];
    }
    
    public function setBirthday($birthday) {
        $this->_data['birthday'] = $birthday;
        
        return $this;
    }
    
    public function getBirthday() {
        return $this->_data['birthday'];
    }
    
    public function setContractNumber($contractNumber) {
        $this->_data['contract_number'] = $contractNumber;
        
        return $this;
    }
    
    public function getContractNumber() {
        return $this->_data['contract_number'];
    }
    
    public function setStatus($status) {
        $this->_data['status'] = $status;
        
        return $this;
    }
    
    public function getStatus() {
        return $this->_data['status'];
    }
    
    public function toArray() {
        return $this->_data;
    }
    
    public function enableTester()
    {
        $this->_data['tester'] = 1;
        return $this;
    }
    
    public function disableTester()
    {
        $this->_data['tester'] = 0;
        return $this;
    }
    
    public function isTester()
    {
        return $this->_data['tester'];
    }
}