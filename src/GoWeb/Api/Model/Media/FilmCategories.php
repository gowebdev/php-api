<?php

namespace GoWeb\Api\Model\Media;

use \GoWeb\Api\Model\Media\FilmCategories\Category;

class FilmCategories extends \GoWeb\Api\Model implements \SeekableIterator, \Countable
{    
    private $_position;

    public function init()
    {
        if(!isset($this->_data['categories']))
            throw new \Exception('Categories was not found');
    }
    
    /**
     * 
     * @param int $categoryId
     * @return \GoWeb\ClientAPI\Model\FilmCategories\Category
     * @throws \Exception
     */
    public function getCategory($categoryId)
    {
        foreach($this as $category)
        {
            if($category->getId() == $categoryId)
            {
                return $category;
            }
        }
        
        throw new \Exception('Category with specified id not found');
    }
    
    public function getFilmGenreList(\GoWeb\Api\Model\Media\FilmList\Film $film, $lengtn = null)
    {
        return $this
            ->getCategory($film->getCategoryId())
            ->getFilmGenreList($film, $lengtn);
    }
    
    public function count()
    {
        return count($this->_data['categories']);
    }

    public function seek($position)
    {
        if (!isset($this->_data['categories'][$position]))
        {
            throw new \OutOfBoundsException("Invalid seek position ($position)");
        }

        $this->_position = $position;
    }

    public function current()
    {
        if ($this->_data['categories'][$this->_position] instanceof Category)
        {
            return $this->_data['categories'][$this->_position];
        }

        $this->_data['categories'][$this->_position] = new Category($this->_data['categories'][$this->_position], $this->_clientAPI);

        return $this->_data['categories'][$this->_position];
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
        return isset($this->_data['categories'][$this->_position]);
    }
}
