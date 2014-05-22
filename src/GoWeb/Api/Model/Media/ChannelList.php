<?php

namespace GoWeb\Api\Model\Media;

class ChannelList extends \Sokil\Rest\Transport\Structure implements \SeekableIterator, \Countable, \IteratorAggregate
{
    private $_listIterator;
    
    protected function getIterator()
    {
        if(!$this->_listIterator) {
            $this->_listIterator = $this->getObjectList('channels', '\GoWeb\Api\Model\Media\ChannelList\Channel');
        }
        
        return $this->_listIterator;
        
    }
    
    public function count()
    {
        return count($this->getIterator());
    }

    public function seek($position)
    {
        $this->getIterator()->seek($position);
    }

    public function current()
    {
        return $this->getIterator()->current();
    }

    public function key()
    {
        return $this->getIterator()->key();
    }

    public function next()
    {
        $this->getIterator()->next();
    }

    public function rewind()
    {
        $this->getIterator()->rewind();
    }

    public function valid()
    {
        return $this->getIterator()->valid();
    }
}
