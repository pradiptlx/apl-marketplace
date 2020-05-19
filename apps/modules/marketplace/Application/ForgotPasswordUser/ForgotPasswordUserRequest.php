<?php


namespace Dex\Marketplace\Application\ForgotPasswordUser;


class ForgotPasswordUserRequest extends \Phalcon\Di\Injectable
{
    protected string $email;
    public bool $isVerify;
    public ?string $token;
    public ?bool $isReset;
    public ?string $password;

    public function __construct(
        string $email,
        bool $isVerify = false,
        string $token = null,
        bool $isReset = false,
        string $password = null
    )
    {
        $this->email = $email;
        $this->isVerify = $isVerify;
        $this->token = $token;
        $this->isReset = $isReset;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }


}
