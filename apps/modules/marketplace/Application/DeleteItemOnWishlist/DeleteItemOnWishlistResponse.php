<?php


namespace Dex\Marketplace\Application\DeleteItemOnWishlist;


use Dex\Marketplace\Application\GenericResponse;

class DeleteItemOnWishlistResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}
