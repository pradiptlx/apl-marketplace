<?php


namespace Dex\Marketplace\Application\TransactionBuyer;


use Dex\Marketplace\Application\GenericResponse;

class TransactionBuyerResponse extends GenericResponse
{

    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}
