<?php

namespace GoWeb\Api\Model\Media;

class FilmCategories extends \Sokil\Rest\Transport\Structure implements \SeekableIterator, \Countable
{    
    private $_filmCategoriesIterator;

    public function init()
    {
        $this->_filmCategoriesIterator = $this->getObjectList('categories', '\GoWeb\Api\Model\Media\FilmCategories\Category');
    }
    
    /**
     * 
     * @param int $categoryId
     * @return \GoWeb\ClientAPI\Model\FilmCategories\Category
     * @throws \Exception
     */
    public function getCategory($categoryId)
    {
        foreach($this->_filmCategoriesIterator as $category) {
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
        return count($this->_filmCategoriesIterator);
    }

    public function seek($position)
    {
        $this->_filmCategoriesIterator->seek($position);
    }

    public function current()
    {
        return $this->_filmCategoriesIterator->current();
    }

    public function key()
    {
        return $this->_filmCategoriesIterator->key();
    }

    public function next()
    {
        $this->_filmCategoriesIterator->next();
    }

    public function rewind()
    {
        $this->_filmCategoriesIterator->rewind();
    }

    public function valid()
    {
        return $this->_filmCategoriesIterator->valid();
    }
}
