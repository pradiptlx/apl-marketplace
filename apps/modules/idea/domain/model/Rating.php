<?php

namespace Idy\Idea\Domain\Model;

use Idy\Idea\Domain\Exception\InvalidRatingException;

class Rating
{
    private $user;
    private $value;

    public function __construct($user, $value) 
    {
        $this->user = $user;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param Rating $rating
     * @return bool
     */
    public function equals(Rating $rating) 
    {
        return $this->user === $rating->user() && 
                $this->value === $rating->value();
    }

    /**
     * @return bool
     * @throws InvalidRatingException
     */
    public function isValid() 
    {
        if ($this->user && $this->value && $this->value >= 0 && $this->value <= 5) {
            return true;
        }

        throw new InvalidRatingException('rating value must be between 0 and 5');
    }

}