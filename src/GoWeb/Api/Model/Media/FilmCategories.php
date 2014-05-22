<?php

namespace GoWeb\Api\Model\Media;

class FilmCategories extends \Sokil\Rest\Transport\Structure implements \SeekableIterator, \Countable
{    
    private $_listIterator;
    
    public function getIterator()
    {
        if(!$this->_listIterator) {
            $this->_listIterator = $this->getObjectList('categories', '\GoWeb\Api\Model\Media\FilmCategories\Category');
        }
        
        return $this->_listIterator;
    }
    
    /**
     * 
     * @param int $categoryId
     * @return \GoWeb\ClientAPI\Model\FilmCategories\Category
     * @throws \Exception
     */
    public function getCategory($categoryId)
    {
        foreach($this->getIterator() as $category) {
            if($category->getId() == $categoryId) {
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
