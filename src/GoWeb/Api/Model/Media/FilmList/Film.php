<?php 

namespace GoWeb\Api\Model\Media\FilmList;

class Film extends \GoWeb\Api\Model 
{
    private $_genres = array();
    
    public function getID()
    {
        if( !isset($this->_data['id']) )
            throw new Exception ('Id of object is not correct');
        
        return $this->_data['id'];
    }
    
    public function getName()
    {
        return isset($this->_data['name']) ? $this->_data['name'] : null;
    }
    
    public function getDescription()
    {
        return isset($this->_data['description']) ? $this->_data['description'] : null;
    }
    
    public function getYear()
    {
        return isset($this->_data['year']) ? $this->_data['year'] : null;
    }
    
    public function getDirector()
    {
        return isset($this->_data['director']) ? $this->_data['director'] : null;
    }
    
    public function getActors()
    {
        return isset($this->_data['actors']) ? $this->_data['actors'] : null;
    }
    
    public function getCountry()
    {
        return isset($this->_data['country']) ? $this->_data['country'] : null;
    }
    
    public function getGenreIdList()
    {
        return isset($this->_data['genres']) ? $this->_data['genres'] : array();
    }
    
    public function getCategoryId()
    {
        return isset($this->_data['category']) ? (int) $this->_data['category'] : null;
    }
    
    public function getDuration()
    {
        return isset($this->_data['duration']) ? $this->_data['duration'] : null;
    }
    
    public function getUrl()
    {
        return isset($this->_data['url']) ? $this->_data['url'] : null;
    }
    
    public function getTorrent()
    {
        return isset($this->_data['torrent']) ? $this->_data['torrent'] : null;
    }
    
    public function getPoster()
    {
        return isset($this->_data['thumb']) ? $this->_data['thumb'] : null;
    }
    
    public function getAgeLimit()
    {
        return isset($this->_data['age_limit']) ? (int) $this->_data['age_limit'] : null;
    }
    
}