<?php

namespace GoWeb\Api\Model\Media;

use \GoWeb\Api\Model\Media\ChannelPrograms\Program;

class ChannelPrograms extends \GoWeb\Api\Model implements \SeekableIterator, \Countable, \ArrayAccess
{    
    private $_channelId;
    
    /**
     *
     * @var array marker if channels block was initialised as program objects list 
     */
    private $_initialised = array();

    public function init()
    {
        if(!isset($this->_data['epg']))
            throw new \Exception('EPG section not found');
    }
    
    public function count()
    {
        return count($this->_data['epg']);
    }

    public function seek($position)
    {
        if (!isset($this->_data['epg'][$position]))
        {
            throw new \OutOfBoundsException("Invalid seek position ($position)");
        }

        $this->_channelId = $position;
    }

    public function current()
    {
        $this->offsetGet($this->_channelId);
    }

    public function key()
    {
        return $this->_channelId;
    }

    public function next()
    {
        ++$this->_channelId;
    }

    public function rewind()
    {
        $this->_channelId = 0;
    }

    public function valid()
    {
        return isset($this->_data['epg'][$this->_channelId]);
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
        if(isset($this->_initialised[$channelId]))
            return $this->_data['epg'][$channelId];

        foreach($this->_data['epg'][$channelId] as $i => $program)
        {
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
