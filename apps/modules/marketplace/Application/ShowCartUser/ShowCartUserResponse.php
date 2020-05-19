<?php


namespace Dex\Marketplace\Application\ShowCartUser;


use Dex\Marketplace\Application\GenericResponse;

class ShowCartUserResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}
