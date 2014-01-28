<?php

namespace GoWeb\Api\Model\Media\FilmCategories\Category;

class Genre extends \GoWeb\Api\Model
{
    public function getId()
    {
        return $this->_data['id'];
    }
    
    public function getName()
    {
        return $this->_data['name'];
    }
}