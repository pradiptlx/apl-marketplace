<?php

namespace Idy\Idea\Domain\Model;

use Exception;
use http\Client\Curl\User;
use Idy\Common\Events\DomainEventPublisher;
use Idy\Idea\Domain\Exception\InvalidRatingException;

class Idea
{
    /**
     * @var IdeaId
     */
    private $id;
    /**
     * @var string $title
     */
    private $title;
    /**
     * @var string $description
     */
    private $description;
    /**
     * @var Author $author
     */
    private $author;
    /**
     * @var Rating[] $ratings
     */
    private $ratings;
    private $votes;

    const INIT_VOTE = 0;
    const INIT_RATINGS = [];

    public function __construct(IdeaId $id, $title, $description, $votes, array $ratings, Author $author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->votes = $votes;

        if (! $ratings) {
            $this->ratings = $ratings;
        } else {
            foreach ($ratings as $rating)
            {
                $this->ratings[] = new Rating($rating['name'], $rating['value']);
            }
        }

    }

    public function appendRating($rating)
    {
        $this->ratings[] = $rating;
    }

    /**
     * @return IdeaId
     */
    public function id() : IdeaId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function title() : string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function description() : string
    {
        return $this->description;
    }

    /**
     * @return Author
     */
    public function author() : Author
    {
        return $this->author;
    }

    public function votes()
    {
        return $this->votes;
    }

    /**
     * @param string $user
     * @param int $ratingValue
     * @return Rating
     * @throws InvalidRatingException
     */
    public function addRating($user, $ratingValue)
    {
        $newRating = new Rating($user, $ratingValue);

        if ($newRating->isValid()) {
            $exist = false;
            foreach ($this->ratings as $existingRating) {
                if ($existingRating->equals($newRating)) {
                    $exist = true;
                }
            }

            if (!$exist) {
                array_push($this->ratings, $newRating);
            } else {
                throw new InvalidRatingException('Author ' . $newRating->user() . ' has given a rating.');
            }

            DomainEventPublisher::instance()->publish(
                new IdeaRated($this->author->name(), $this->author->email(), 
                    $this->title, $ratingValue, $user)
            );

            return $newRating;
        }
    }

    public function vote()
    {   
        $this->votes = $this->votes + 1;
    }

    /**
     * @return float
     */
    public function averageRating() : float
    {
        $numberOfRatings = count($this->ratings);
        if (! $numberOfRatings) return 0;

        $totalRatings = 0;

        foreach ($this->ratings as $rating) {
            $totalRatings += $rating->value();
        }

        return ($totalRatings / $numberOfRatings);
    }

    /**
     * @param string $title
     * @param string $description
     * @param int $votes
     * @param Author $author
     * @return Idea
     */
    public static function makeIdea($title, $description, $votes, $author) : Idea
    {
        return new Idea(new IdeaId(), $title, $description, $votes, self::INIT_RATINGS, $author);
    }

    /**
     * @return int
     */
    public function numberOfRatings() : int
    {
        return count($this->ratings);
    }

}