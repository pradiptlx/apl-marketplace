<?php


namespace Dex\Marketplace\Application\ForgotPasswordUser;


class ForgotPasswordUserRequest extends \Phalcon\Di\Injectable
{
    protected string $email;

    public function __construct(
        string $email
    )
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }



}
