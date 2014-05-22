<?php

namespace GoWeb\Api\Model\Media\FilmCategories\Category;

class Genre extends \Sokil\Rest\Transport\Structure
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