<?php 

namespace GoWeb\Api\Model\Media\FilmCategories;

use \GoWeb\Api\Model\Media\FilmCategories\Category\Genre;

class Category extends \GoWeb\Api\Model 
{
    private $_initialised = false;
    
    public function getId()
    {
        return $this->_data['id'];
    }
    
    public function getName()
    {
        return $this->_data['name'];
    }
    
    public function getGenres()
    {
        if($this->_initialised)
            return $this->_data['genres'];
        
        foreach($this->_data['genres'] as $i => $genre)
        {
            $this->_data['genres'][$i] = new Genre($genre, $this->_clientAPI);
        }
        
        $this->_initialised = true;
        
        return $this->_data['genres'];
    }
    
    /**
     * 
     * @param int $length number of genres to return
     * @return array
     */
    public function getFilmGenreList(\GoWeb\Api\Model\Media\FilmList\Film $film, $length = null)
    {
        $genres = array();
        $genreIdList = $film->getGenreIdList();
        
        foreach($this->getGenres() as $genre)
        {
            if(!in_array($genre->getId(), $genreIdList)) {
                continue;
            }
            
            $genres[$genre->getId()] = $genre->getName(); 
        }
        
        if(!$length) {
            return $genres;
        }
        
        return array_slice($genres, 0, $length);
    }
}
