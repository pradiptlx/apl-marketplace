<?php


namespace Dex\Marketplace\Application\DecreaseWishlistProductCounter;


use Dex\Marketplace\Application\GenericResponse;

class DecreaseWishlistProductCounterResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }
}
