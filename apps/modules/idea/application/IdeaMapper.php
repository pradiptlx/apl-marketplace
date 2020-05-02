<?php

namespace Idy\Idea\Application;


use Idy\Idea\Domain\Model\Author;
use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\Rating;

class IdeaMapper
{
    /**
     * @var Idea[]
     */
    protected $ideasAndRatings = [];

    public function __construct(array $ideas, array $ratings)
    {
        foreach ($ideas as $idea)
        {
            $author = new Author($idea['author_name'], $idea['author_email']);
            $ideaId = new IdeaId($idea['id']);
            $this->ideasAndRatings[$idea['id']] = new Idea($ideaId, $idea['title'], $idea['description'], $idea['votes'], Idea::INIT_RATINGS, $author);
        }

        foreach ($ratings as $rating)
        {
            $r = new Rating($rating['name'], $rating['value']);
            $idea = $this->ideasAndRatings[$rating['idea_id']];
            $idea->appendRating($r);
            $this->ideasAndRatings[$rating['idea_id']] = $idea;
        }
    }

    /**
     * @return Idea[]
     */
    public function get() : array
    {
        return $this->ideasAndRatings;
    }
}