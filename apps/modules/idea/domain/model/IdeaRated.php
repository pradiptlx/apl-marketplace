<?php

namespace Idy\Idea\Domain\Model;

use Idy\Common\Events\DomainEvent;

class IdeaRated implements DomainEvent 
{
    private $name;
    private $email;
    private $title;
    private $rating;
    private $rater;

    private $occuredOn;

    public function name()
    {
        return $this->name;
    }

    public function email()
    {
        return $this->email;
    }

    public function rating()
    {
        return $this->rating;
    }

    public function title()
    {
        return $this->title;
    }

    public function rater()
    {
        return $this->rater;
    }

    public function __construct(
        $name, $email, $title, $rating, $rater)
    {
        $this->name = $name;
        $this->email = $email;
        $this->title = $title;
        $this->rating = $rating;
        $this->rater = $rater;
    }

    /**
    * @return DateTimeImmutable
    */
    public function occurredOn()
    {
        return $this->occuredOn;
    }
}