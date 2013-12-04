<?php

namespace Films\CatalogBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Films\CatalogBundle\Entity\Film;

class RatingUpdatedEvent extends Event{

    protected $entry;
    protected $score;

    function __construct(Film $entry, $score)
    {
        $this->entry = $entry;
        $this->score = $score;
    }

    /**
     * @return Film
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

}