<?php

namespace GoWeb\API;

class Model extends \Sokil\Rest\Transport\Structure
{   
    /**
     * @deprecated use self::get()
     * @param type $selector
     * @return type
     */
    public function getParam($selector)
    {
        return $this->get($selector);
    }
    
    /**
     * @deprecated return self::set()
     * 
     * @param type $selector
     * @param type $value
     * @return \GoWeb\API\Model
     */
    public function setParam($selector, $value)
    {
        $this->set($selector, $value);        
        return $this;
    }
}
