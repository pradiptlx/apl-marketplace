<?php


namespace Dex\Marketplace\Application\AddToCartBuyer;


use Dex\Marketplace\Application\GenericResponse;

class AddToCartBuyerResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}
