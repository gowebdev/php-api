<?php 

namespace GoWeb\Api\Model\Media\ChannelList;

class Channel extends \GoWeb\Api\Model 
{
    public function getTorrent()
    {
        return isset($this->_data['torrent']) ? $this->_data['torrent'] : null;
    }
    
    public function getUrl()
    {
        return isset($this->_data['url']) ? $this->_data['url'] : null;
    }
    
    public function getName()
    {
        return isset($this->_data['name']) ? $this->_data['name'] : 'Unknown';
    }
    
    public function getLogo()
    {
        return $this->_data['logo'];
    }
    
    public function getAlias()
    {
        return $this->_data['alias'];
    }
    
    public function getXmltvId()
    {
        return $this->_data['xmltv'];
    }
    
    public function getId()
    {
        return $this->_data['channel_id'];
    }
    
    public function getGenre()
    {
        return $this->_data['genre'];
    }
    
    public function getGenreId()
    {
        return $this->_data['genre_id'];
    }
    
    public function isFavourite()
    {
        return !empty($this->_data['fav']);
    }
    
    public function getNumber()
    {
        return (int) $this->_data['number'];
    }
    
    public function isHD() 
    {
        return isset($this->_data['hd']) && $this->_data['hd'];
    }
    
    public function getAgeLimit()
    {
        return isset($this->_data['age_limit']) ? (int) $this->_data['age_limit'] : null;
    }
}