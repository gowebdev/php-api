<?php 

namespace GoWeb\Api\Model\Media\ChannelPrograms;

class Program extends \Sokil\Rest\Transport\Structure
{
    public function getName()
    {
        return $this->get('name');
    }
    
    public function getStartTime($format = null)
    {
        return $format ? date($format, $this->get('from')) : (int) $this->get('from');
    }
    
    public function getFinishTime($format = null)
    {
        return $format ? date($format, $this->get('to')) : (int) $this->get('to');
    }
    
    public function isFinished()
    {
        return $this->getFinishTime() < time();
    }
    
    public function getUrl()
    {
        if(!$this->isFinished()) {
            return null;
        }
        
        return $this->get('url');
    }
    
    public function getTorrent()
    {
        if(!$this->isFinished()) {
            return null;
        }
        
        return $this->get('torrent');
    }
}