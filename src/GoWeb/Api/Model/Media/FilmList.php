<?php

namespace GoWeb\Api\Model\Media;

use GoWeb\Api\Model\Media\FilmList\Film;

class FilmList extends \GoWeb\Api\Model implements \SeekableIterator, \Countable
{    
    private $_position = 0;

    public function init()
    {

    }
    
    public function count()
    {
        return count($this->_data['items']);
    }

    public function seek($position)
    {
        if (!isset($this->_data['items'][$position]))
        {
            throw new \OutOfBoundsException("Invalid seek position ($position)");
        }

        $this->_position = $position;
    }

    public function current()
    {
        if(empty($this->_data['items'][$this->_position])) {
            return null;
        }
        
        if($this->_data['items'][$this->_position] instanceof Film) {
            return $this->_data['items'][$this->_position];
        }

        $this->_data['items'][$this->_position] = new Film($this->_data['items'][$this->_position], $this->_clientAPI);

        return $this->_data['items'][$this->_position];
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
        return isset($this->_data['items'][$this->_position]);
    }
}
