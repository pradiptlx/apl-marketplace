<?php

namespace Idy\Idea\Application\CreateNewIdea;

use Idy\Idea\Application\GenericResponse;

class CreateNewIdeaResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }
}