<?php


namespace Dex\Marketplace\Application\CreateUserAccount;


use Dex\Marketplace\Application\GenericResponse;

class CreateUserAccountResponse extends GenericResponse
{

    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }


}
