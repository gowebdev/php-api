<?php

namespace GoWeb\Api\Model\Media\FilmCategories\Category;

class Genre extends \GoWeb\Api\Model
{
    public function getId()
    {
        return $this->get('id');
    }
    
    public function getName()
    {
        return $this->get('name');
    }
}