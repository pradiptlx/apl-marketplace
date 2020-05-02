<?php

namespace Idy\Idea\Application\RateIdea;

class RateIdeaRequest
{
    protected $ideaId;
    protected $value;
    protected $name;

    /**
     * RateIdeaRequest constructor.
     * @param $ideaId
     * @param $value
     * @param $name
     * @param $email
     */
    public function __construct($ideaId, $value, $name)
    {
        $this->ideaId = $ideaId;
        $this->value = $value;
        $this->name = $name;
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

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
}