<?php


namespace Dex\Marketplace\Application\IncrementCartProductCounter;


use Dex\Marketplace\Application\GenericResponse;

class IncrementCartProductCounterResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}