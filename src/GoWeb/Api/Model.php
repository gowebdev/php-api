<?php

namespace GoWeb\API;

class Model implements \Serializable
{
    protected $_data;

    /**
     *
     * @var \GoWeb\ClientAPI
     */
    protected $_clientAPI;

    public function __construct(array $data = null)
    {
        if($data) {
            $this->_data = $data;
        }

        $this->init();
    }

    public function init() {}

    public function toArray()
    {
        return $this->_data;
    }
    
    public function __toString()
    {
        return $this->serialize();
    }
    
    public function getParam($selector)
    {
        if(false === strpos($selector, '.'))
            return  isset($this->_data[$selector]) ? $this->_data[$selector] : null;

        $value = $this->_data;
        foreach(explode('.', $selector) as $field)
        {
            if(!isset($value[$field]))
                return null;

            $value = $value[$field];
        }

        return $value;
    }
    
    public function setParam($selector, $value)
    {
        if(!$selector) {
            throw new \Exception('Selector not specified');
        }
        
        $arraySelector = explode('.', $selector);
        $chunksNum = count($arraySelector);
        
        // optimize one-level selector search
        if(1 == $chunksNum)
        {
            $this->_data[$selector] = $value;
            
            return $this;
        }
        
        // selector is nested
        $section = &$this->_data;

        for($i = 0; $i < $chunksNum - 1; $i++)
        {

            $field = $arraySelector[$i];

            if(!isset($section[$field]))
            {
                $section[$field] = array();
            }

            $section = &$section[$field];

        }
        
        $section[$arraySelector[$chunksNum - 1]] = $value;
        
        return $this;
    }
    
        
    public function serialize()
    {
        return json_encode($this->toArray());
    }
    
    public function unserialize($serialized)
    {
        $this->_data = json_decode($serialized, true);
        
        return $this;
    }
}
