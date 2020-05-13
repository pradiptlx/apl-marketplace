<?php


namespace Dex\Marketplace\Application\ShowItemDetailBuyer;


use Dex\Marketplace\Application\GenericResponse;

class ShowItemDetailBuyerResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}
