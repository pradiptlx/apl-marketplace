<?php

namespace Idy\Idea\Application\VoteIdea;

use Idy\Idea\Application\GenericResponse;

class VoteIdeaResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }
}