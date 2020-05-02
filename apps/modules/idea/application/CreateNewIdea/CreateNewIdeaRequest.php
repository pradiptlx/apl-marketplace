<?php

namespace Idy\Idea\Application\CreateNewIdea;

class CreateNewIdeaRequest
{
    public $ideaTitle;
    public $ideaDescription;
    public $authorName;
    public $authorEmail;

    public function __construct($ideaTitle, $ideaDescription, $authorName, $authorEmail)
    {
        $this->ideaTitle = $ideaTitle;
        $this->ideaDescription = $ideaDescription;
        $this->authorName = $authorName;
        $this->authorEmail = $authorEmail;
    }

    /**
     * @return mixed
     */
    public function getIdeaTitle()
    {
        return $this->ideaTitle;
    }

    /**
     * @param mixed $ideaTitle
     */
    public function setIdeaTitle($ideaTitle)
    {
        $this->ideaTitle = $ideaTitle;
    }

    /**
     * @return mixed
     */
    public function getIdeaDescription()
    {
        return $this->ideaDescription;
    }

    /**
     * @param mixed $ideaDescription
     */
    public function setIdeaDescription($ideaDescription)
    {
        $this->ideaDescription = $ideaDescription;
    }

    /**
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param mixed $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return mixed
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * @param mixed $authorEmail
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
    }



}