<?php


namespace Dex\Marketplace\Application\GetProductBySellerId;


use Dex\Marketplace\Application\GenericResponse;

class GetProductBySellerIdResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}
