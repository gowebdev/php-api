<?php

namespace GoWeb\Api\Model\Media;

class FilmList extends \Sokil\Rest\Transport\Structure implements \SeekableIterator, \Countable
{    
    private $_listIterator;
    
    public function init()
    {
        $this->_listIterator = $this->getObjectList('items', '\GoWeb\Api\Model\Media\FilmList\Film');
    }
    
    public function count()
    {
        return count($this->_listIterator);
    }

    public function seek($position)
    {
        $this->_listIterator->seek($position);
    }

    public function current()
    {
        return $this->_listIterator->current();
    }

    public function key()
    {
        return $this->_listIterator->key();
    }

    public function next()
    {
        $this->_listIterator->next();
    }

    public function rewind()
    {
        $this->_listIterator->rewind();
    }

    public function valid()
    {
        return $this->_listIterator->valid();
    }
}
