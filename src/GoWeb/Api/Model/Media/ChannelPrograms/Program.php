<?php 

namespace GoWeb\Api\Model\Media\ChannelPrograms;

class Program extends \GoWeb\Api\Model
{
    public function getName()
    {
        return $this->_data['name'];
    }
    
    public function getStartTime($format = null)
    {
        return $format ? date($format, $this->_data['from']) : (int) $this->_data['from'];
    }
    
    public function getFinishTime($format = null)
    {
        return $format ? date($format, $this->_data['to']) : (int) $this->_data['to'];
    }
    
    public function isFinished()
    {
        return $this->getFinishTime() < time();
    }
    
    public function getUrl()
    {
        if(!$this->isFinished())
            return null;
        
        return isset($this->_data['url']) ? $this->_data['url'] : null;
    }
    
    public function getTorrent()
    {
        if(!$this->isFinished())
            return null;
        
        return isset($this->_data['torrent']) ? $this->_data['torrent'] : null;
    }
}