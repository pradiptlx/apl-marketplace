<?php


namespace Dex\Marketplace\Application\CreateUserAccount;


class CreateUserAccountRequest
{
    protected string $username;
    protected string $fullname;
    protected string $password;
    protected string $email;
    protected string $address;
    protected string $telp_no;
    protected ?string $status_user;

    public function __construct(
        string $username,
        string $fullname,
        string $password,
        string $email,
        string $address,
        string $telp_no,
        string $status_user = null
    )
    {
        $this->username = $username;
        $this->fullname = $fullname;
        $this->password = $password;
        $this->email = $email;
        $this->address = $address;
        $this->telp_no = $telp_no;
        $this->status_user = $status_user;

    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getTelp(): string
    {
        return $this->telp_no;
    }

    public function getStatusUser(): ?string
    {
        return $this->status_user;
    }

}
