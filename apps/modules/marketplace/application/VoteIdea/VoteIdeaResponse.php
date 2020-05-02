<?php

namespace Dex\Marketplace\Application\VoteIdea;

use Dex\Marketplace\Application\GenericResponse;

class VoteIdeaResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }
}
