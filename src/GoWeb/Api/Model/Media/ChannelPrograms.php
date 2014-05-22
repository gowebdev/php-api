<?php

namespace GoWeb\Api\Model\Media;

use \GoWeb\Api\Model\Media\ChannelPrograms\Program;

class ChannelPrograms extends \Sokil\Rest\Transport\Structure implements \ArrayAccess, \Countable
{    
    /**
     *
     * @var array marker if channels block was initialised as program objects list 
     */
    private $_initialised = array();

    public function init()
    {
        if(!isset($this->_data['epg'])) {
            throw new \Exception('EPG section not found');
        }
    }
    
    public function count()
    {
        return count($this->_data['epg']);
    }
    
    public function offsetExists($channelId)
    {
        return isset($this->_data['epg'][$channelId]);
    }
    
    public function offsetUnset($channelId)
    {
        unset($this->_data['epg'][$channelId]);
    }
    
    public function offsetGet($channelId)
    {
        if(isset($this->_initialised[$channelId])) {
            return $this->_data['epg'][$channelId];
        }

        foreach($this->_data['epg'][$channelId] as $i => $program) {
            $this->_data['epg'][$channelId][$i] = new Program($program, $this->_clientAPI);
        }
        
        $this->_initialised[$channelId] = true;

        return $this->_data['epg'][$channelId];
    }
    
    public function offsetSet($channelId, $value)
    {
        $this->_data['epg'][$channelId] = $value;
    }
}
