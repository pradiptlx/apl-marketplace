<?php

namespace Idy\Idea\Application\RateIdea;

use Idy\Idea\Application\GenericResponse;

class RateIdeaResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }
}