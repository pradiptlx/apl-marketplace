<?php

namespace Dex\Marketplace\Application\CreateNewIdea;

use Dex\Marketplace\Application\GenericResponse;

class CreateNewIdeaResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }
}
