<?php

namespace GoWeb\Api\Model\Client;

class Profile extends \Sokil\Rest\Transport\Structure
{
    
    public function setId($id) {
        $this->set('id', (int) $id);
        
        return $this;
    }
    
    public function getId() {
        return $this->get('id') ? (int) $this->get('id') : null;
    }
    
    public function setEmail($email) {
        $this->set('email', $email);
        
        return $this;
    }
    
    public function getEmail() {
        return $this->get('email');
    }
    
    public function setPassword($password) {
        $this->set('password', $password);
        
        return $this;
    }
    
    public function getPassword() {
        return $this->get('password');
    }
    
    public function setHash($hash) {
        $this->set('hash', $hash);
        
        return $this;
    }
    
    public function getHash() {
        return $this->get('hash');
    }
    
    public function setLastName($lastName) {
        $this->set('last_name', $lastName);
        
        return $this;
    }
    
    public function getLastName() {
        return $this->get('last_name');
    }
    
    public function setFirstName($firstName) {
        $this->set('first_name', $firstName);
        
        return $this;
    }
    
    public function getFirstName() {
        return $this->get('first_name');
    }
    
    public function setGender($gender) {
        $this->set('gender', $gender);
        
        return $this;
    }
    
    public function getGender() {
        return $this->get('gender');
    }
    
    public function setBirthday($birthday) {
        $this->set('birthday', $birthday);
        
        return $this;
    }
    
    public function getBirthday() {
        return $this->get('birthday');
    }
    
    public function setContractNumber($contractNumber) {
        $this->set('contract_number', $contractNumber);
        
        return $this;
    }
    
    public function getContractNumber() {
        return $this->get('contract_number');
    }
    
    public function setStatus($status) {
        $this->set('status', $status);
        
        return $this;
    }
    
    public function getStatus() {
        return $this->get('status');
    }
    
    public function setAgent($agent)
    {
        $this->set('agent', $agent);
        return $this;
    }
    
    public function getAgent()
    {
        return $this->get('agent');
    }
    
    public function enableTester()
    {
        $this->set('tester', 1);
        return $this;
    }
    
    public function disableTester()
    {
        $this->set('tester', 0);
        return $this;
    }
    
    public function isTester()
    {
        return (bool) $this->get('tester');
    }
}