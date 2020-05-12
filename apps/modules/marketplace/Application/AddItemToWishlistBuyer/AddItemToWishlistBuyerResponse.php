<?php


namespace Dex\Marketplace\Application\AddItemToWishlistBuyer;


use Dex\Marketplace\Application\GenericResponse;

class AddItemToWishlistBuyerResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}
