<?php


namespace Dex\Marketplace\Application\DecreaseCartProductCounter;


use Dex\Marketplace\Application\GenericResponse;

class DecreaseCartProductCounterResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }
}
