<?php

namespace GoWeb\Api\Model\Media;

use \GoWeb\Api\Model\Media\ChannelList\Channel;

class ChannelList extends \GoWeb\Api\Model implements \SeekableIterator, \Countable
{    
    private $_position;

    public function init()
    {
        if(!isset($this->_data['channels']))
            throw new \Exception('Channels section not found');
    }
    
    public function count()
    {
        return count($this->_data['channels']);
    }

    public function seek($position)
    {
        if (!isset($this->_data['channels'][$position]))
        {
            throw new \OutOfBoundsException("Invalid seek position ($position)");
        }

        $this->_position = $position;
    }

    public function current()
    {
        if ($this->_data['channels'][$this->_position] instanceof Channel)
            return $this->_data['channels'][$this->_position];

        $this->_data['channels'][$this->_position] = new Channel($this->_data['channels'][$this->_position], $this->_clientAPI);

        return $this->_data['channels'][$this->_position];
    }

    public function key()
    {
        return $this->_position;
    }

    public function next()
    {
        ++$this->_position;
    }

    public function rewind()
    {
        $this->_position = 0;
    }

    public function valid()
    {
        return isset($this->_data['channels'][$this->_position]);
    }
}
