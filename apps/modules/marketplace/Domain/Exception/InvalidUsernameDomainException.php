<?php


namespace Dex\Marketplace\Domain\Exception;

use Throwable;

class InvalidUsernameDomainException extends \Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
