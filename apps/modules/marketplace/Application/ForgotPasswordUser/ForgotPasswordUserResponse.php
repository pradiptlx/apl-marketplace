<?php


namespace Dex\Marketplace\Application\ForgotPasswordUser;


use Dex\Marketplace\Application\GenericResponse;

class ForgotPasswordUserResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }



}
