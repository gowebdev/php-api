<?php 

namespace GoWeb\Api\Model\Media\ChannelList;

class Channel extends \Sokil\Rest\Transport\Structure
{
    public function getTorrent()
    {
        return $this->get('torrent');
    }
    
    public function getUrl()
    {
        return $this->get('url');
    }
    
    public function getName()
    {
        return $this->get('name', 'Unknown');
    }
    
    public function getLogo()
    {
        return $this->get('logo');
    }
    
    public function getAlias()
    {
        return $this->get('alias');
    }
    
    public function getXmltvId()
    {
        return $this->get('xmltv');
    }
    
    public function getId()
    {
        return $this->get('channel_id');
    }
    
    public function getGenre()
    {
        return $this->get('genre');
    }
    
    public function getGenreId()
    {
        return $this->get('genre_id');
    }
    
    public function isFavourite()
    {
        return (bool) $this->get('fav');
    }
    
    public function getNumber()
    {
        return (int) $this->get('number');
    }
    
    public function isHD() 
    {
        return (bool) $this->get('hd');
    }
    
    public function getAgeLimit()
    {
        return (bool) $this->get('age_limit');
    }
}