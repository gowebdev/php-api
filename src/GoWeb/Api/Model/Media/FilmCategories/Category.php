<?php 

namespace GoWeb\Api\Model\Media\FilmCategories;

class Category extends \GoWeb\Api\Model 
{
    private $_genresIterator;
    
    public function getId()
    {
        return $this->get('id');
    }
    
    public function getName()
    {
        return $this->get('name');
    }
    
    public function getGenres()
    {
        if($this->_genresIterator) {
            return $this->_genresIterator;
        }
        
        $this->_genresIterator = $this->getObjectList('genres', '\GoWeb\Api\Model\Media\FilmCategories\Category\Genre');
        
        return $this->_genresIterator;
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
