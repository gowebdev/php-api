<?php

namespace GoWeb\Api\Model\Client;

class ClientAdditionalService extends AbstractClientService
{    
    
    public function getAdditionalServiceId()
    {
        return $this->get('service_id');
    }
    
    public function setAdditionalServiceId($id)
    {
        $this->set('service_id', (int) $id);
        return $this; 
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