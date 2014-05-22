<?php

namespace GoWeb\Api\Model\Media;

class ChannelList extends \Sokil\Rest\Transport\Structure implements \SeekableIterator, \Countable
{
    /**
     *
     * @var \Sokil\Rest\Transport\StructureList 
     */
    private $_channelsIterator;
    
    public function init()
    {
        $this->_channelsIterator = $this->getObjectList('channels', '\GoWeb\Api\Model\Media\ChannelList\Channel');
    }
    
    public function count()
    {
        return count($this->_channelsIterator);
    }

    public function seek($position)
    {
        $this->_channelsIterator->seek($position);
    }

    public function current()
    {
        return $this->_channelsIterator->current();
    }

    public function key()
    {
        return $this->_channelsIterator->key();
    }

    public function next()
    {
        $this->_channelsIterator->next();
    }

    public function rewind()
    {
        $this->_channelsIterator->rewind();
    }

    public function valid()
    {
        return $this->_channelsIterator->valid();
    }
}
