<?php


namespace Dex\Marketplace\Application\IncrementProductCounter;


use Dex\Marketplace\Application\GenericResponse;

class IncrementProductCounterResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}
