<?php


namespace Dex\Marketplace\Application\ListItemsBuyer;


use Dex\Marketplace\Application\GenericResponse;

class ListItemsBuyerResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}
