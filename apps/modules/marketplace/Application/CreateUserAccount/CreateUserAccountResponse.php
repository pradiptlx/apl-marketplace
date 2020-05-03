<?php


namespace Dex\Marketplace\Application;


class CreateUserAccountResponse extends GenericResponse
{

    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }


}
