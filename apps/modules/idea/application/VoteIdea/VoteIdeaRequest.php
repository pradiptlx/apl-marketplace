<?php

namespace Idy\Idea\Application\VoteIdea;

class VoteIdeaRequest
{
    protected $ideaId;

    /**
     * VoteIdeaRequest constructor.
     * @param $ideaId
     */
    public function __construct($ideaId)
    {
        $this->ideaId = $ideaId;
    }

    /**
     * @return mixed
     */
    public function getIdeaId()
    {
        return $this->ideaId;
    }

    /**
     * @param mixed $ideaId
     */
    public function setIdeaId($ideaId): void
    {
        $this->ideaId = $ideaId;
    }

}