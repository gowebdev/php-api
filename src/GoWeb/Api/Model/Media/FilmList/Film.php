<?php 

namespace GoWeb\Api\Model\Media\FilmList;

class Film extends \Sokil\Rest\Transport\Structure
{    
    public function getId()
    {
        return $this->get('id');
    }
    
    public function getName()
    {
        return $this->get('name');
    }
    
    public function getDescription()
    {
        return $this->get('description');
    }
    
    public function getYear()
    {
        return $this->get('year');
    }
    
    public function getDirector()
    {
        return $this->get('director');
    }
    
    public function getActors()
    {
        return $this->get('actors');
    }
    
    public function getCountry()
    {
        return $this->get('country');
    }
    
    public function getGenreIdList()
    {
        return $this->get('genres', []);
    }
    
    public function getCategoryId()
    {
        return $this->get('category');
    }
    
    public function getDuration()
    {
        return $this->get('duration');
    }
    
    public function getUrl()
    {
        return $this->get('url');
    }
    
    public function getTorrent()
    {
        return $this->get('torrent');
    }
    
    public function getPoster()
    {
        return $this->get('thumbn');
    }
    
    public function getAgeLimit()
    {
        return $this->get('age_limit');
    }
    
}